<?php

namespace App\Services\VoiceAssistant;

/**
 * A text-generation backend for the voice assistant. Swap the binding in
 * AppServiceProvider to use a provider with a different API shape.
 */
interface ChatProvider
{
    /**
     * Whether credentials and a model are configured.
     */
    public function isConfigured(): bool;

    /**
     * @param  array<int, array{role: 'system'|'user'|'assistant', content: string}>  $messages
     *
     * @throws ProviderException when the provider is unreachable, rejects the request or returns no text
     */
    public function complete(array $messages): string;
}
