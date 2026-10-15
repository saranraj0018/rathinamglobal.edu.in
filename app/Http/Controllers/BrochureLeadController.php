<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrochureLeadRequest;
use App\Services\AppsScriptClient;
use App\Support\BrochureGrant;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * ESG / ESIA enquiry leads (/esg/lead, /esia/lead).
 *
 * The lead is forwarded server-to-server to Apps Script and, only when the
 * sheet confirms the row, the visitor's session receives a short-lived grant
 * to download the brochure. Nothing the browser does can unlock it otherwise.
 */
class BrochureLeadController extends Controller
{
    public function __construct(private BrochureGrant $grants) {}

    /**
     * Lets a reloaded page pick up the grant its session already earned.
     */
    public function show(Request $request, string $site): JsonResponse
    {
        if (! $request->has('grant')) {
            return $this->reply(['success' => false, 'message' => 'Method not allowed.'], 405);
        }

        $grant = $this->grants->current($site);

        if ($grant === null) {
            return $this->reply(['granted' => false]);
        }

        return $this->reply([
            'granted' => true,
            'download' => ['token' => $grant['token'], 'expires' => $grant['expires'] * 1000],
        ]);
    }

    public function store(StoreBrochureLeadRequest $request, string $site, AppsScriptClient $appsScript): JsonResponse
    {
        if ($request->isHoneypotTriggered()) {
            // Look successful to the bot; write nothing, grant nothing.
            return $this->reply(['success' => true, 'message' => 'Thank you.']);
        }

        $settings = config("rgu.brochure_leads.sites.{$site}");
        $appsScriptUrl = config('rgu.brochure_leads.apps_script_url');

        // target_sheet comes from config, never from the request, so a crafted
        // payload cannot write into another tab of the spreadsheet.
        $payload = [
            'full_name' => (string) $request->input('full_name'),
            'email' => (string) $request->input('email'),
            'mobile' => (string) $request->input('mobile'),
            'current_role' => mb_substr((string) $request->input('current_role', ''), 0, 120),
            'organization' => mb_substr((string) $request->input('organization', ''), 0, 120),
            'programme' => mb_substr((string) $request->input('programme', ''), 0, 120) ?: $settings['default_programme'],
            'form_name' => mb_substr((string) $request->input('form_name', ''), 0, 60),
            'target_sheet' => $settings['target_sheet'],
            'page_url' => mb_substr((string) $request->input('page_url', ''), 0, 300),
            'elapsed' => (int) $request->input('elapsed', 0),
            'ip' => (string) $request->ip(),
        ];

        if (blank($appsScriptUrl)) {
            Log::error('[brochure-lead] BROCHURE_LEADS_APPS_SCRIPT_URL is not configured.');

            return $this->reply(['success' => false, 'message' => 'We could not reach the server. Please try again in a moment.'], 502);
        }

        try {
            $response = $appsScript->postJson($appsScriptUrl, $payload);
        } catch (ConnectionException $e) {
            Log::error('[brochure-lead] upstream failed', ['error' => $e->getMessage()]);

            return $this->reply(['success' => false, 'message' => 'We could not reach the server. Please try again in a moment.'], 502);
        }

        $upstream = json_decode($response->body(), true);

        // "duplicate": this person is already in the sheet. They handed over
        // their details to get here, so they still receive the brochure.
        $duplicate = is_array($upstream) && ($upstream['code'] ?? '') === 'duplicate';

        if (! is_array($upstream) || (empty($upstream['success']) && ! $duplicate)) {
            Log::warning('[brochure-lead] upstream rejected (HTTP '.$response->status().')', ['body' => substr($response->body(), 0, 500)]);

            return $this->reply([
                'success' => false,
                'field' => $upstream['field'] ?? null,
                'message' => $upstream['message'] ?? 'Something went wrong. Please try again.',
            ]);
        }

        $grant = $this->grants->issue($site, $payload['email'], $this->brochureFor($payload['programme'], $settings['default_brochure']));

        return $this->reply([
            'success' => true,
            'duplicate' => $duplicate,
            'message' => $duplicate ? 'You have already registered. Your brochure is ready.' : ($upstream['message'] ?? 'Thank you.'),
            'download' => ['token' => $grant['token'], 'expires' => $grant['expires'] * 1000, 'kind' => $grant['kind']],
        ]);
    }

    /**
     * Which brochure the lead earned is decided by the programme chosen in the
     * form, not by the page it was submitted on. ESIA is matched first: its
     * option text does not contain "ESG", while the ESG option does.
     */
    private function brochureFor(string $programme, string $default): string
    {
        $kind = match (true) {
            preg_match('/esia|environmental\s*&?\s*social/i', $programme) === 1 => 'esia',
            preg_match('/\besg\b/i', $programme) === 1 => 'esg',
            default => $default,
        };

        return config("rgu.brochure_leads.brochures.{$kind}") !== null ? $kind : $default;
    }

    /**
     * @param  array<string, mixed>  $body
     */
    private function reply(array $body, int $status = 200): JsonResponse
    {
        return response()->json($body, $status)->header('Cache-Control', 'no-store');
    }
}
