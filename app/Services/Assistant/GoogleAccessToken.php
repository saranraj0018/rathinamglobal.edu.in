<?php

namespace App\Services\Assistant;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Authenticates calls to Google Cloud Text-to-Speech and Speech-to-Text,
 * either with a service-account file (GOOGLE_APPLICATION_CREDENTIALS, signed
 * JWT exchanged for a short-lived token) or with a restricted GOOGLE_API_KEY.
 * Credentials stay on the server and are never logged.
 */
class GoogleAccessToken
{
    public function isConfigured(): bool
    {
        return $this->credentialsFile() !== null || filled(config('assistant.google.api_key'));
    }

    /**
     * Headers/query that authorise a request.
     *
     * @return array{headers: array<string, string>, query: array<string, string>}
     *
     * @throws RuntimeException
     */
    public function authorization(): array
    {
        $credentials = $this->credentialsFile();

        if ($credentials === null) {
            if (blank(config('assistant.google.api_key'))) {
                throw new RuntimeException('Google Cloud credentials are not configured.');
            }

            return ['headers' => [], 'query' => ['key' => (string) config('assistant.google.api_key')]];
        }

        $token = Cache::remember('assistant:google-token', 3000, fn (): string => $this->fetchToken($credentials));

        return ['headers' => ['Authorization' => 'Bearer '.$token], 'query' => []];
    }

    /**
     * @return array{client_email: string, private_key: string, token_uri?: string}|null
     */
    private function credentialsFile(): ?array
    {
        $path = config('assistant.google.credentials');

        if (blank($path) || ! is_readable($path)) {
            return null;
        }

        $json = json_decode((string) file_get_contents($path), true);

        return is_array($json) && isset($json['client_email'], $json['private_key']) ? $json : null;
    }

    /**
     * @param  array{client_email: string, private_key: string, token_uri?: string}  $credentials
     */
    private function fetchToken(array $credentials): string
    {
        $uri = $credentials['token_uri'] ?? 'https://oauth2.googleapis.com/token';
        $encode = fn (string $data): string => rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        $now = time();
        $unsigned = $encode((string) json_encode(['alg' => 'RS256', 'typ' => 'JWT'])).'.'.$encode((string) json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud' => $uri,
            'iat' => $now,
            'exp' => $now + 3600,
        ]));

        if (! openssl_sign($unsigned, $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Could not sign the Google credentials JWT.');
        }

        $response = Http::asForm()->timeout((int) config('assistant.google.timeout'))->post($uri, [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $unsigned.'.'.$encode($signature),
        ]);

        if ($response->failed() || blank($response->json('access_token'))) {
            throw new RuntimeException('Google token request failed with HTTP '.$response->status().'.');
        }

        return (string) $response->json('access_token');
    }
}
