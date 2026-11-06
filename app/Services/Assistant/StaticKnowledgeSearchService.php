<?php

namespace App\Services\Assistant;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * THIS IS NEW CODE — searches approved, bundled Rathinam data without requiring the database.
 */
class StaticKnowledgeSearchService
{
    /** THIS IS NEW CODE — excludes presentation-only metadata from answer evidence. */
    private const EXCLUDED_KEYS = ['image', 'icon', 'color', 'url', 'slug', 'class', 'style', 'video', 'dimension'];

    public function __construct(private TextNormalizer $normalizer) {}

    /**
     * THIS IS NEW CODE — rank matching local facts with the assistant's shared Tamil/English normalizer.
     *
     * @return list<RetrievedChunk>
     */
    public function search(string $question): array
    {
        $units = $this->normalizer->units($question);

        // THIS IS NEW CODE — use the official hostel overview for broad hostel questions. Reason: the indexed FAQ contains only a link-like placeholder, while Rathinam's official campus page publishes real facilities.
        $hostelStems = ['hostel', 'hostal', 'accommodation', 'viduthi', 'vidudhi'];
        $facilityStems = ['facility', 'facilities', 'amenities', 'vasathi', 'vasadhi', 'vasathigal'];
        $isBroadHostelQuestion = $units !== []
            && count($units) <= 2
            && array_all($units, fn (array $unit): bool => array_intersect($unit['stems'], [...$hostelStems, ...$facilityStems]) !== []);
        if ($isBroadHostelQuestion) {
            $hostelFacts = require resource_path('data/assistant/hostel.php');
            $language = $this->normalizer->detectLanguage($question) === TextNormalizer::ENGLISH ? 'en' : 'ta';

            return [new RetrievedChunk(0, 'static_data', 0, 'Verified Hostel Facilities', $hostelFacts[$language], 1.0)];
        }

        if ($units === []) {
            // THIS IS NEW CODE — answer broad institutional overview questions with an approved fact bundle. Reason: normalisation intentionally removes generic words, leaving queries such as “about Rathinam College” empty.
            if (preg_match('/\b(rathinam|rgu|college|university)\b|ரத்தினம்|கல்லூரி|பல்கலைக்கழகம்/iu', $question) === 1
                && preg_match('/\b(about|overview|information|tell|describe)\b|பற்றி|சொல்லு|தெரிவி/iu', $question) === 1) {
                $overview = require resource_path('data/assistant-institution.php');

                return [new RetrievedChunk(0, 'static_data', 0, 'Rathinam Global University overview', $overview['content'], 1.0)];
            }

            return [];
        }

        $results = [];
        foreach ($this->dataFiles() as $path) {
            $data = require $path;
            $lines = [];
            $this->collectText($data, $lines);
            $content = implode("\n", array_unique($lines));
            if ($content === '') {
                continue;
            }

            $present = $this->normalizer->stemSet($content);
            $specificStems = array_merge(...array_column(array_values(array_filter($units, fn (array $unit): bool => ! $unit['concept'])), 'stems')) ?: [];
            $relevantLines = array_values(array_filter($lines, function (string $line) use ($specificStems): bool {
                $lineStems = $this->normalizer->stemSet($line);

                return array_filter($specificStems, fn (string $stem): bool => isset($lineStems[$stem])) !== [];
            }));
            $weight = 0;
            $matched = 0;
            $hasSpecific = false;
            $matchedSpecific = false;
            foreach ($units as $unit) {
                $weight += $unit['weight'];
                $hasSpecific = $hasSpecific || ! $unit['concept'];
                $found = array_filter($unit['stems'], fn (string $stem): bool => isset($present[$stem])) !== [];
                if ($found) {
                    $matched += $unit['weight'];
                    $matchedSpecific = $matchedSpecific || ! $unit['concept'];
                }
            }

            if ($weight === 0 || ($hasSpecific && ! $matchedSpecific)) {
                continue;
            }

            $score = $matched / $weight;
            if ($score < max(0.25, (float) config('assistant.min_relevance_score'))) {
                continue;
            }

            $relative = str_replace('\\', '/', substr($path, strlen(resource_path('data/'))));
            $title = ucwords(str_replace(['-', '/', '.php'], [' ', ' / ', ''], $relative));
            $evidence = implode("\n", array_slice($relevantLines ?: $lines, 0, 12));
            $results[] = new RetrievedChunk(0, 'static_data', 0, $title, mb_substr($evidence, 0, 1800), $score);
        }

        usort($results, fn (RetrievedChunk $a, RetrievedChunk $b): int => $b->score <=> $a->score);

        return array_slice($results, 0, (int) config('assistant.retrieval_limit', 5));
    }

    /** THIS IS NEW CODE — only plain text leaves from the approved data files enter the prompt. */
    private function collectText(mixed $value, array &$lines, ?string $key = null): void
    {
        if ($key !== null && collect(self::EXCLUDED_KEYS)->contains(fn (string $excluded): bool => str_contains(mb_strtolower($key), $excluded))) {
            return;
        }

        if (is_string($value)) {
            $text = html_entity_decode(trim(strip_tags($value)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if (mb_strlen($text) >= 3 && ! str_starts_with($text, '#')) {
                $lines[] = $text;
            }

            return;
        }

        if (is_array($value)) {
            foreach ($value as $childKey => $child) {
                $this->collectText($child, $lines, is_string($childKey) ? $childKey : null);
            }
        }
    }

    /** THIS IS NEW CODE — restrict local evidence to explicit approved data folders/files. */
    private function dataFiles(): array
    {
        $root = resource_path('data');
        $programmeFiles = [];
        $programmeRoot = $root.'/programmes';
        if (is_dir($programmeRoot)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($programmeRoot, FilesystemIterator::SKIP_DOTS)) as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $programmeFiles[] = $file->getPathname();
                }
            }
        }
        $files = array_merge(
            glob($root.'/*.php') ?: [],
            glob($root.'/schools/*.php') ?: [],
            $programmeFiles,
            glob($root.'/research/*.php') ?: [],
            glob($root.'/events/*.php') ?: [],
        );

        return array_values(array_unique(array_filter($files, fn (string $path): bool => is_file($path))));
    }
}
