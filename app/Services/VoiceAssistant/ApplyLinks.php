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

    public function __construct(private ContentRepository $content, private KnowledgeBase $knowledge) {}

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
     * The link for a visitor's message when it asks to apply, join or enrol; null otherwise.
     * Earlier questions in the conversation decide the stream when this one does not name it.
     *
     * @param  array<int, string>  $earlierQuestions  most recent last
     */
    public function detect(string $message, array $earlierQuestions = []): ?string
    {
        if (! $this->wantsToApply($message)) {
            return null;
        }

        foreach ([$message, ...array_reverse($earlierQuestions)] as $text) {
            $key = $this->matchStream($text);

            if ($key !== null) {
                return $key;
            }
        }

        return self::DEFAULT_KEY;
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

    public function wantsToApply(string $text): bool
    {
        $normalised = $this->normalise($text);

        foreach ($this->config()['intent'] as $phrase) {
            if ($this->find($normalised, $phrase) !== null) {
                return true;
            }
        }

        return false;
    }

    /**
     * The link whose keywords (and school programme names) the text mentions most. A keyword
     * inside a longer matched phrase does not count, so "computer science engineering" is
     * engineering rather than "computer science". Ties go to the link listed first.
     */
    public function matchStream(string $text): ?string
    {
        $normalised = $this->normalise($text);
        $matches = [];

        foreach ($this->config()['links'] as $key => $link) {
            foreach ($this->keywords($link) as $keyword) {
                $span = $this->find($normalised, $keyword);

                if ($span !== null) {
                    $matches[] = ['key' => $key, 'start' => $span[0], 'end' => $span[1]];
                }
            }
        }

        $counts = [];

        foreach ($matches as $match) {
            $isInsideLonger = false;

            foreach ($matches as $other) {
                if ($other !== $match && $other['start'] <= $match['start'] && $other['end'] >= $match['end']
                    && ($other['end'] - $other['start']) > ($match['end'] - $match['start'])) {
                    $isInsideLonger = true;
                    break;
                }
            }

            if (! $isInsideLonger) {
                $counts[$match['key']] = ($counts[$match['key']] ?? 0) + 1;
            }
        }

        if ($counts === []) {
            return null;
        }

        $best = max($counts);

        foreach (array_keys($this->config()['links']) as $key) {
            if (($counts[$key] ?? 0) === $best) {
                return $key;
            }
        }

        return null;
    }

    /**
     * @param  array{keywords?: array<int, string>, schools?: array<int, string>}  $link
     * @return array<int, string>
     */
    private function keywords(array $link): array
    {
        $keywords = $link['keywords'] ?? [];

        foreach ($link['schools'] ?? [] as $slug) {
            array_push($keywords, ...$this->knowledge->schoolProgrammes($slug));
        }

        return array_values(array_unique($keywords));
    }

    /**
     * Where the phrase occurs in the normalised text, as [start, end]: whole words for
     * English, a stem (prefix) match for Tamil so inflected forms also count.
     *
     * @return array{0: int, 1: int}|null
     */
    private function find(string $normalised, string $phrase): ?array
    {
        $phrase = trim($this->normalise($phrase));

        if ($phrase === '') {
            return null;
        }

        $isTamil = preg_match('/\p{Tamil}/u', $phrase) === 1;
        $position = mb_strpos($normalised, $isTamil ? ' '.$phrase : ' '.$phrase.' ');

        return $position === false ? null : [$position, $position + mb_strlen($phrase) + 1];
    }

    /**
     * Lowercase words separated by single spaces and padded with one, dots removed ("B.E" = "be").
     */
    private function normalise(string $text): string
    {
        $text = str_replace('.', '', mb_strtolower($text));
        $text = trim((string) preg_replace('/[^\p{L}\p{M}\p{N}]+/u', ' ', $text));

        return ' '.$text.' ';
    }

    /**
     * @return array{intent: array<int, string>, default: array{label: array<string, string>, url: string}, links: array<string, array{label: array<string, string>, url: string, description?: string, schools?: array<int, string>, keywords?: array<int, string>}>}
     */
    private function config(): array
    {
        return $this->content->get('voice-assistant')['apply'];
    }
}
