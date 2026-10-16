<?php

namespace App\Services\VoiceAssistant;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Any provider that implements the OpenAI "POST {base}/chat/completions"
 * format: Google Gemini (OpenAI compatibility endpoint), Groq, OpenRouter,
 * OpenAI, Ollama and others. Only the base URL, key and model differ.
 */
class OpenAiCompatibleProvider implements ChatProvider
{
    public function __construct(
        private ?string $apiKey,
        private ?string $model,
        private ?string $baseUrl,
        private int $timeout = 20,
        private int $maxTokens = 800,
    ) {}

    public function isConfigured(): bool
    {
        return filled($this->apiKey) && filled($this->model) && filled($this->baseUrl);
    }

    public function complete(array $messages): string
    {
        if (! $this->isConfigured()) {
            throw new ProviderException('AI provider is not configured.');
        }

        try {
            $response = Http::baseUrl(rtrim((string) $this->baseUrl, '/'))
                ->withToken((string) $this->apiKey)
                ->acceptJson()
                ->connectTimeout(5)
                ->timeout($this->timeout)
                // One quick retry for a dropped connection or a provider hiccup; a 4xx is final.
                ->retry([400], 0, fn (Throwable $e): bool => $e instanceof ConnectionException
                    || ($e instanceof RequestException && $e->response->serverError()), throw: false)
                ->post('/chat/completions', [
                    'model' => $this->model,
                    'messages' => $messages,
                    'temperature' => 0.2,
                    'max_tokens' => $this->maxTokens,
                ]);
        } catch (ConnectionException $e) {
            throw new ProviderException('AI provider unreachable: '.$e->getMessage(), previous: $e);
        }

        if ($response->failed()) {
            // The error body never echoes the key; it is trimmed so a long payload cannot flood the log.
            throw new ProviderException(sprintf(
                'AI provider returned HTTP %d: %s',
                $response->status(),
                mb_substr((string) ($response->json('error.message') ?? $response->body()), 0, 300),
            ));
        }

        $content = $response->json('choices.0.message.content');

        if (! is_string($content) || trim($content) === '') {
            throw new ProviderException('AI provider returned no text (finish_reason: '.($response->json('choices.0.finish_reason') ?? 'unknown').').');
        }

        return $content;
    }
}
