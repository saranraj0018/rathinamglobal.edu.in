<?php

namespace App\Support;

use Illuminate\Session\Store;
use Illuminate\Support\Str;

/**
 * Session-scoped permission to download a brochure, issued once a lead has
 * reached the sheet. Grants are per site, so the ESG form does not unlock
 * the ESIA brochure session key and vice versa.
 */
class BrochureGrant
{
    public function __construct(private Store $session) {}

    /**
     * @return array{token: string, expires: int, email: string, kind: string}
     */
    public function issue(string $site, string $email, string $kind): array
    {
        $grant = [
            'token' => Str::random(64),
            'expires' => now()->addSeconds((int) config('rgu.brochure_leads.grant_ttl'))->getTimestamp(),
            'email' => $email,
            'kind' => $kind,
        ];

        $this->session->put($this->key($site), $grant);

        return $grant;
    }

    /**
     * The unexpired grant for this site, if any.
     *
     * @return array{token: string, expires: int, email: string, kind: string}|null
     */
    public function current(string $site): ?array
    {
        $grant = $this->session->get($this->key($site));

        if (! is_array($grant) || empty($grant['token']) || now()->getTimestamp() >= (int) $grant['expires']) {
            return null;
        }

        return $grant;
    }

    /**
     * @return array{token: string, expires: int, email: string, kind: string}|null
     */
    public function raw(string $site): ?array
    {
        $grant = $this->session->get($this->key($site));

        return is_array($grant) ? $grant : null;
    }

    public function revoke(string $site): void
    {
        $this->session->forget($this->key($site));
    }

    private function key(string $site): string
    {
        return "brochure_grant_{$site}";
    }
}
