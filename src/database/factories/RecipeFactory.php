<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'image_url' => fake()->imageUrl(),
            'description' => fake()->text(),
            'ingredients' => fake()->sentence(),
            'steps' => fake()->sentence(),
            'author_id' => fake()->uuid(),
            'category_id' => Category::factory(),
        ];
    }
}
