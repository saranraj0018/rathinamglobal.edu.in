<?php

namespace App\Services\Assistant;

/**
 * One piece of admin-managed knowledge returned for a question.
 */
final readonly class RetrievedChunk
{
    public function __construct(
        public int $chunkId,
        public string $sourceType,
        public int $sourceId,
        public string $title,
        public string $content,
        public float $score,
    ) {}

    /**
     * @return array{id: int, type: string, title: string, score: float}
     */
    public function toSource(): array
    {
        return ['id' => $this->sourceId, 'type' => $this->sourceType, 'title' => $this->title, 'score' => round($this->score, 3)];
    }
}
