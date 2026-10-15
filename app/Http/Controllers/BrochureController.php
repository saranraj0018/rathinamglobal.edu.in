<?php

namespace App\Http\Controllers;

use App\Support\BrochureGrant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Streams a gated brochure PDF (/esg/brochure, /esia/brochure) to a session
 * that holds a valid grant. The PDFs live on the private "local" disk.
 *
 *   ?t=<token>          the grant token handed back with the lead reply
 *   ?mode=download      save as a file (default opens inline)
 *
 * Range requests are honoured, as PDF viewers fetch large files in chunks.
 */
class BrochureController extends Controller
{
    public function show(Request $request, string $site, BrochureGrant $grants): BinaryFileResponse|Response
    {
        $grant = $grants->raw($site);

        if ($grant === null || empty($grant['token'])) {
            return $this->deny(403, 'Please complete the enquiry form to download the brochure.');
        }

        if ($grants->current($site) === null) {
            $grants->revoke($site);

            return $this->deny(403, 'This download link has expired. Please submit the form again.');
        }

        $token = (string) $request->query('t', '');

        if ($token === '' || ! hash_equals((string) $grant['token'], $token)) {
            return $this->deny(403, 'Invalid download link.');
        }

        $brochures = config('rgu.brochure_leads.brochures');
        $brochure = $brochures[$grant['kind']] ?? $brochures[config("rgu.brochure_leads.sites.{$site}.default_brochure")];
        $disk = Storage::disk('local');

        if (! $disk->exists($brochure['path'])) {
            Log::error('[brochure] missing file', ['path' => $brochure['path']]);

            return $this->deny(404, 'The brochure is temporarily unavailable.');
        }

        $disposition = $request->query('mode') === 'download'
            ? ResponseHeaderBag::DISPOSITION_ATTACHMENT
            : ResponseHeaderBag::DISPOSITION_INLINE;

        return response()
            ->file($disk->path($brochure['path']), [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'private, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'X-Robots-Tag' => 'noindex, nofollow',
            ])
            ->setContentDisposition($disposition, $brochure['download_name']);
    }

    /**
     * Refuse without revealing whether the file exists.
     */
    private function deny(int $status, string $message): Response
    {
        return response($message, $status, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'no-store',
        ]);
    }
}
