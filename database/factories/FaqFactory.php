<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_en' => fake()->sentence().'?',
            'answer_en' => fake()->paragraph(),
            'is_active' => true,
            'published_at' => now()->subMinute(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(['published_at' => null]);
    }

    public function disabled(): static
    {
        return $this->state(['is_active' => false]);
    }
}
