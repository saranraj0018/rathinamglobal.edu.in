<?php

namespace App\Services\VoiceAssistant;

use App\Support\ContentRepository;

/**
 * Where a visitor who wants to apply is sent (resources/data/voice-assistant.php, "apply").
 *
 * Only the links listed there can ever be returned, whatever the visitor or
 * the AI says, so a reply can never redirect to an unknown site.
 *
 * @phpstan-type Redirect array{key: string, url: string, label: string}
 */
class ApplyLinks
{
    public const DEFAULT_KEY = 'general';

    public function __construct(private ContentRepository $content) {}

    /**
     * The choices offered to the AI, keyed by the tag it may answer with.
     *
     * @return array<string, string>
     */
    public function choices(): array
    {
        $choices = [];

        foreach ($this->config()['links'] as $key => $link) {
            $choices[$key] = $link['description'] ?? $link['label']['en'];
        }

        return $choices + [self::DEFAULT_KEY => 'the visitor wants to apply but the programme or stream is not clear'];
    }

    /**
     * @return Redirect|null
     */
    public function redirect(string $key, string $language): ?array
    {
        $config = $this->config();
        $link = $key === self::DEFAULT_KEY ? $config['default'] : ($config['links'][$key] ?? null);

        if ($link === null) {
            return null;
        }

        return [
            'key' => $key,
            'url' => $link['url'],
            'label' => $link['label'][$language] ?? $link['label']['en'],
        ];
    }

    /**
     * @return array{default: array{label: array<string, string>, url: string}, links: array<string, array{label: array<string, string>, url: string, description?: string}>}
     */
    private function config(): array
    {
        return $this->content->get('voice-assistant')['apply'];
    }
}
