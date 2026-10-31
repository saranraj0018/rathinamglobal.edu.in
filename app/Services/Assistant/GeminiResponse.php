<?php

namespace App\Services\Assistant;

final readonly class GeminiResponse
{
    public function __construct(
        public string $text,
        public string $model,
        public ?int $promptTokens,
        public ?int $completionTokens,
    ) {}
}
