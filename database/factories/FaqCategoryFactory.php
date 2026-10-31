<?php

namespace Database\Factories;

use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FaqCategory>
 */
class FaqCategoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return ['name_en' => ucfirst($name), 'name_ta' => null, 'slug' => str($name)->slug()->toString(), 'sort_order' => 0, 'is_active' => true];
    }
}
