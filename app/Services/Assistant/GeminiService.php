<?php

namespace App\Services\Assistant;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Calls the Gemini generateContent REST API from the backend only.
 *
 * The model comes from GEMINI_MODEL (never hardcoded: models get retired).
 * Transient failures (timeouts, 429/5xx) are retried a few times; failures
 * that retrying cannot fix (bad key, unknown model) fail at once. Logs carry
 * the failure reason and token counts, never the key or the visitor's text.
 */
class GeminiService
{
    public function isConfigured(): bool
    {
        return filled(config('assistant.gemini.key')) && filled(config('assistant.gemini.model'));
    }

    /**
     * @param  list<array{role: 'user'|'model', text: string}>  $turns  oldest first, ending with the visitor's turn
     *
     * @throws GeminiException
     */
    public function generate(string $systemInstruction, array $turns): GeminiResponse
    {
        if (! $this->isConfigured()) {
            throw new GeminiException(GeminiException::NOT_CONFIGURED, 'Gemini API key or model is not set.');
        }

        $config = config('assistant.gemini');
        $model = $config['model'];
        $url = "{$config['url']}/models/{$model}:generateContent";
        $payload = [
            'systemInstruction' => ['parts' => [['text' => $systemInstruction]]],
            'contents' => array_map(fn (array $turn): array => ['role' => $turn['role'], 'parts' => [['text' => $turn['text']]]], $turns),
            'generationConfig' => [
                'maxOutputTokens' => $config['max_output_tokens'],
                'temperature' => $config['temperature'],
            ],
        ];

        $attempts = max(1, $config['retries'] + 1);

        for ($attempt = 1; ; $attempt++) {
            try {
                $response = Http::withHeaders(['x-goog-api-key' => $config['key']])
                    ->acceptJson()
                    ->connectTimeout(5)
                    ->timeout($config['timeout'])
                    ->post($url, $payload);

                return $this->parse($response, $model);
            } catch (ConnectionException) {
                $failure = new GeminiException(GeminiException::TIMEOUT, 'Could not reach Gemini.');
            } catch (GeminiException $e) {
                $failure = $e;
            }

            $transient = in_array($failure->reason, [GeminiException::TIMEOUT, GeminiException::UNAVAILABLE], true);

            Log::warning('[assistant] Gemini call failed', ['reason' => $failure->reason, 'attempt' => $attempt, 'model' => $model]);

            if (! $transient || $attempt >= $attempts) {
                throw $failure;
            }

            usleep((int) $config['retry_delay_ms'] * 1000 * $attempt);
        }
    }

    /**
     * @throws GeminiException
     */
    private function parse(Response $response, string $model): GeminiResponse
    {
        if ($response->failed()) {
            $status = $response->status();
            $detail = (string) $response->json('error.status', '');
            $message = mb_substr((string) $response->json('error.message', ''), 0, 200);

            throw match (true) {
                $status === 429 || $detail === 'RESOURCE_EXHAUSTED' => new GeminiException(GeminiException::QUOTA, $message),
                $status === 404 || $detail === 'NOT_FOUND' => new GeminiException(GeminiException::MODEL_NOT_FOUND, $message),
                in_array($status, [401, 403], true) || str_contains($message, 'API key') => new GeminiException(GeminiException::INVALID_KEY, $message),
                $status >= 500 => new GeminiException(GeminiException::UNAVAILABLE, $message),
                default => new GeminiException(GeminiException::BAD_RESPONSE, "HTTP {$status}: {$message}"),
            };
        }

        $candidate = $response->json('candidates.0');
        $text = collect($candidate['content']['parts'] ?? [])->pluck('text')->filter()->implode('');

        if ($text === '') {
            throw new GeminiException(
                filled($response->json('promptFeedback.blockReason')) || ($candidate['finishReason'] ?? '') === 'SAFETY'
                    ? GeminiException::BLOCKED
                    : GeminiException::BAD_RESPONSE,
                'Gemini returned no text.',
            );
        }

        $usage = $response->json('usageMetadata', []);

        Log::info('[assistant] Gemini call ok', [
            'model' => $model,
            'prompt_tokens' => $usage['promptTokenCount'] ?? null,
            'completion_tokens' => $usage['candidatesTokenCount'] ?? null,
        ]);

        return new GeminiResponse(trim($text), $model, $usage['promptTokenCount'] ?? null, $usage['candidatesTokenCount'] ?? null);
    }
}
