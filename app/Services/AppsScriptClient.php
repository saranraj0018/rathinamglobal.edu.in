<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Server-to-server relay to Google Apps Script web apps (the Google Sheets
 * behind the enquiry and registration forms).
 *
 * Apps Script answers /exec with a 302 to script.googleusercontent.com, so
 * redirects are followed to get the real body back.
 */
class AppsScriptClient
{
    /**
     * POST url-encoded fields.
     *
     * @param  array<string, scalar>  $fields
     *
     * @throws ConnectionException
     */
    public function postForm(string $url, array $fields, int $timeout = 20): Response
    {
        return Http::asForm()
            ->withUserAgent('RathinamGlobal/1.0')
            ->connectTimeout(10)
            ->timeout($timeout)
            ->post($url, $fields);
    }

    /**
     * POST a JSON document as text/plain, which Apps Script reads from
     * e.postData.contents without a CORS preflight.
     *
     * @param  array<string, mixed>  $payload
     *
     * @throws ConnectionException
     */
    public function postJson(string $url, array $payload, int $timeout = 25): Response
    {
        return Http::withBody(
            json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'text/plain;charset=utf-8',
        )
            ->connectTimeout(10)
            ->timeout($timeout)
            ->post($url);
    }
}
