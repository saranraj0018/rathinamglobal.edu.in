<?php

namespace App\Services\Assistant;

/**
 * Splits long documents into chunks along paragraph and sentence borders so
 * each chunk stays about one topic and a retrieved chunk reads on its own.
 */
class ChunkSplitter
{
    /**
     * @return list<string>
     */
    public function split(string $content, int $maxLength): array
    {
        $paragraphs = preg_split('/\R{2,}/u', trim($content)) ?: [];
        $chunks = [];
        $current = '';

        foreach ($paragraphs as $paragraph) {
            foreach ($this->fit(trim($paragraph), $maxLength) as $piece) {
                if ($current !== '' && mb_strlen($current) + mb_strlen($piece) + 2 > $maxLength) {
                    $chunks[] = $current;
                    $current = '';
                }

                $current = $current === '' ? $piece : $current."\n\n".$piece;
            }
        }

        if ($current !== '') {
            $chunks[] = $current;
        }

        return $chunks;
    }

    /**
     * @return list<string>
     */
    private function fit(string $paragraph, int $maxLength): array
    {
        if ($paragraph === '') {
            return [];
        }

        if (mb_strlen($paragraph) <= $maxLength) {
            return [$paragraph];
        }

        $pieces = [];
        $current = '';

        foreach (preg_split('/(?<=[.!?।])\s+/u', $paragraph) ?: [] as $sentence) {
            while (mb_strlen($sentence) > $maxLength) {
                $pieces[] = mb_substr($sentence, 0, $maxLength);
                $sentence = mb_substr($sentence, $maxLength);
            }

            if ($current !== '' && mb_strlen($current) + mb_strlen($sentence) + 1 > $maxLength) {
                $pieces[] = $current;
                $current = '';
            }

            $current = $current === '' ? $sentence : $current.' '.$sentence;
        }

        if ($current !== '') {
            $pieces[] = $current;
        }

        return $pieces;
    }
}
