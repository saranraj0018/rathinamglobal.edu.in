<?php

namespace Database\Factories;

use App\Models\KnowledgeDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KnowledgeDocument>
 */
class KnowledgeDocumentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'category' => fake()->randomElement(KnowledgeDocument::CATEGORIES),
            'language' => 'en',
            'content' => fake()->paragraphs(2, true),
            'status' => KnowledgeDocument::STATUS_PUBLISHED,
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => KnowledgeDocument::STATUS_DRAFT]);
    }
}
