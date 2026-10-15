<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusRegistrationRequest;
use App\Services\AppsScriptClient;
use App\Support\ContentRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * AC bus service registration (/acbus).
 *
 * The page posts here instead of straight to Google Apps Script: the relay
 * removes CORS / opaque-response failures and returns the sheet's real
 * answer, so the page never shows "success" for a row that did not land.
 */
class BusRegistrationController extends Controller
{
    /** Fields copied through to the sheet, in order. */
    private const SHEET_FIELDS = [
        'name', 'studentId', 'department', 'phone', 'email',
        'interestedInAC', 'busNo', 'pickupLocation', 'preferredRoute',
        'earlyBirdOffer', 'timestamp',
    ];

    public function create(ContentRepository $content): View
    {
        return view('bus-registration.create', ['routes' => $content->get('bus-routes')]);
    }

    public function store(StoreBusRegistrationRequest $request, AppsScriptClient $appsScript): JsonResponse
    {
        if ($request->isHoneypotTriggered()) {
            Log::notice('[ac-bus] honeypot triggered', ['ip' => $request->ip()]);

            // Answer as if it succeeded so bots get no signal to retry differently.
            return $this->reply(true, 'Registration received.');
        }

        if (($failure = $this->verifyTurnstile($request)) !== null) {
            return $failure;
        }

        $appsScriptUrl = config('rgu.bus_registration.apps_script_url');

        if (blank($appsScriptUrl)) {
            Log::error('[ac-bus] BUS_REGISTRATION_APPS_SCRIPT_URL is not configured.');

            return $this->reply(false, 'We could not reach the registration service. Please try again in a moment.', 502);
        }

        $payload = [];
        foreach (self::SHEET_FIELDS as $field) {
            $payload[$field] = trim((string) $request->input($field, ''));
        }
        if ($payload['timestamp'] === '') {
            $payload['timestamp'] = CarbonImmutable::now('Asia/Kolkata')->format('d/m/Y, h:i:s A');
        }

        try {
            $response = $appsScript->postForm($appsScriptUrl, $payload);
        } catch (ConnectionException $e) {
            Log::error('[ac-bus] apps script transport error', ['error' => $e->getMessage()]);

            return $this->reply(false, 'We could not reach the registration service. Please try again in a moment.', 502);
        }

        if (! $response->successful()) {
            Log::error('[ac-bus] apps script HTTP '.$response->status(), ['body' => substr($response->body(), 0, 500)]);

            return $this->reply(false, 'The registration service rejected the request. Please contact the transport office.', 502);
        }

        $body = $response->body();

        // An Apps Script deployment that is not public answers with a Google sign-in page and HTTP 200.
        if (stripos($body, '<html') !== false && stripos($body, 'accounts.google.com') !== false) {
            Log::error('[ac-bus] apps script returned a Google login page — set the deployment access to "Anyone".');

            return $this->reply(false, 'Registration service is not accepting public submissions yet. Please contact the transport office.', 502);
        }

        // {"status": "success"|"duplicate"|"error"}; older templates use "result".
        $decoded = json_decode($body, true);
        $status = is_array($decoded) ? strtolower(trim((string) ($decoded['status'] ?? $decoded['result'] ?? ''))) : '';

        return match ($status) {
            '', 'success' => $this->reply(true, 'Registration received.'),
            // Final answer: the sheet already has this Student ID or email, so retrying cannot help.
            'duplicate' => $this->reply(false, 'This Student ID or email is already registered. Contact the transport office if you need to change your details.', 409, ['code' => 'duplicate']),
            default => $this->upstreamError($status, $body),
        };
    }

    /**
     * Cloudflare Turnstile check; skipped when no secret is configured.
     */
    private function verifyTurnstile(StoreBusRegistrationRequest $request): ?JsonResponse
    {
        $secret = config('rgu.bus_registration.turnstile_secret');

        if (blank($secret)) {
            return null;
        }

        $token = (string) $request->input('cf-turnstile-response', '');

        if ($token === '') {
            return $this->reply(false, 'Please complete the security verification.', 400);
        }

        try {
            $result = Http::asForm()->connectTimeout(10)->timeout(20)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ])->json();
        } catch (ConnectionException) {
            $result = null;
        }

        if (empty($result['success'])) {
            Log::warning('[ac-bus] turnstile rejected', ['result' => $result]);

            return $this->reply(false, 'Security verification failed. Please retry the checkbox.', 403);
        }

        return null;
    }

    private function upstreamError(string $status, string $body): JsonResponse
    {
        Log::error('[ac-bus] apps script status "'.$status.'"', ['body' => substr($body, 0, 500)]);

        return $this->reply(false, 'The registration could not be saved. Please try again.', 502, ['code' => 'upstream']);
    }

    /**
     * @param  array<string, string>  $extra
     */
    private function reply(bool $ok, string $message, int $status = 200, array $extra = []): JsonResponse
    {
        return response()
            ->json(['ok' => $ok, 'message' => $message] + $extra, $status, [], JSON_UNESCAPED_SLASHES)
            ->header('Cache-Control', 'no-store');
    }
}
