<?php

namespace App\Services\Assistant;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    // OLD CODE — NOT USED NOW: this signature could not correlate provider latency to the caller's request.
    // public function generate(string $systemInstruction, array $turns): GeminiResponse
    // THIS IS NEW CODE — carry the originating request ID into upstream timings without logging prompt text or secrets.
    public function generate(string $systemInstruction, array $turns, ?string $requestId = null, ?int $startedAt = null): GeminiResponse
    {
        $requestId ??= (string) Str::uuid();
        $startedAt ??= hrtime(true);
        if (! $this->isConfigured()) {
            throw new GeminiException(GeminiException::NOT_CONFIGURED, 'Gemini API key or model is not set.');
        }

        $config = config('assistant.gemini');
        $model = $config['model'];
        // THIS IS NEW CODE — keep the existing .env untouched while preventing Live-only IDs from reaching generateContent.
        if (preg_match('/(?:^|[-.])(?:live|transcribe)(?:[-.]|$)/i', $model) === 1) {
            $model = 'gemini-3.8-flash';
            // OLD CODE — NOT USED NOW: this warning omitted the originating request ID and elapsed time.
            // Log::warning('[assistant] Live-only model configured for text; using a text-capable fallback', ['fallback_model' => $model]);
            Log::warning('[assistant] Live-only model configured for text; using a text-capable fallback', [
                'fallback_model' => $model,
                'request_id' => $requestId,
                'elapsed_ms' => $this->elapsedMs($startedAt),
            ]);
        }

        $url = "{$config['url']}/models/{$model}:generateContent";
        $payload = [
            'systemInstruction' => ['parts' => [['text' => $systemInstruction]]],
            'contents' => array_map(fn (array $turn): array => ['role' => $turn['role'], 'parts' => [['text' => $turn['text']]]], $turns),
            'generationConfig' => [
                'maxOutputTokens' => $config['max_output_tokens'],
            ],
        ];

        $attempts = max(1, $config['retries'] + 1);

        for ($attempt = 1; ; $attempt++) {
            $attemptStartedAt = hrtime(true);
            try {
                $response = Http::withHeaders(['x-goog-api-key' => $config['key']])
                    ->acceptJson()
                    ->connectTimeout(5)
                    ->timeout($config['timeout'])
                    ->post($url, $payload);

                $reply = $this->parse($response, $model, $requestId, $startedAt, $attemptStartedAt, $attempt);

                return $reply;
            } catch (ConnectionException) {
                $failure = new GeminiException(GeminiException::TIMEOUT, 'Could not reach Gemini.');
            } catch (GeminiException $e) {
                $failure = $e;
            }

            $transient = in_array($failure->reason, [GeminiException::TIMEOUT, GeminiException::UNAVAILABLE], true);

            Log::warning('[assistant.lifecycle] gemini_attempt_failed', [
                'request_id' => $requestId,
                'elapsed_ms' => $this->elapsedMs($startedAt),
                'stage_elapsed_ms' => $this->elapsedMs($attemptStartedAt),
                'reason' => $failure->reason,
                'upstream_message' => mb_substr($failure->getMessage(), 0, 200),
                'attempt' => $attempt,
                'model' => $model,
            ]);

            if (! $transient || $attempt >= $attempts) {
                throw $failure;
            }

            usleep((int) $config['retry_delay_ms'] * 1000 * $attempt);
        }
    }

    /**
     * @throws GeminiException
     */
    private function parse(Response $response, string $model, string $requestId, int $startedAt, int $attemptStartedAt, int $attempt): GeminiResponse
    {
        if ($response->failed()) {
            $status = $response->status();
            $detail = (string) $response->json('error.status', '');
            $message = mb_substr((string) $response->json('error.message', ''), 0, 200);
            Log::warning('[assistant.lifecycle] gemini_http_response', [
                'request_id' => $requestId,
                'elapsed_ms' => $this->elapsedMs($startedAt),
                'stage_elapsed_ms' => $this->elapsedMs($attemptStartedAt),
                'http_status' => $status,
                'upstream_status' => $detail,
                'upstream_message' => $message,
                'attempt' => $attempt,
            ]);

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

        // OLD CODE — NOT USED NOW: successful provider logs lacked request correlation and elapsed time.
        // Log::info('[assistant] Gemini call ok', ['model' => $model, 'prompt_tokens' => $usage['promptTokenCount'] ?? null, 'completion_tokens' => $usage['candidatesTokenCount'] ?? null]);
        Log::info('[assistant] Gemini call ok', [
            'model' => $model,
            'prompt_tokens' => $usage['promptTokenCount'] ?? null,
            'completion_tokens' => $usage['candidatesTokenCount'] ?? null,
            'request_id' => $requestId,
            'elapsed_ms' => $this->elapsedMs($startedAt),
        ]);
        Log::info('[assistant.lifecycle] gemini_http_success', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'stage_elapsed_ms' => $this->elapsedMs($attemptStartedAt), 'http_status' => $response->status(), 'attempt' => $attempt]);

        return new GeminiResponse(trim($text), $model, $usage['promptTokenCount'] ?? null, $usage['candidatesTokenCount'] ?? null);
    }

    /** THIS IS NEW CODE — compute monotonic timings for correlated lifecycle logs. */
    private function elapsedMs(int $startedAt): int
    {
        return (int) ((hrtime(true) - $startedAt) / 1_000_000);
    }
}
