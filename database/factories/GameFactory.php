<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'published_at' => fake()->date(),
            'description' => fake()->text(200),
            'img_path' => "/storage/images/test.jpg",
            'EAN' => fake()->unique()->numberBetween(1000, 9999),
            'min_players' => fake()->numberBetween(1, 5),
            'max_players' => fake()->numberBetween(5, 10),
            'average_duration' => fake()->numberBetween(15, 180),
            'suggestedage' => fake()->numberBetween(6, 99),
        ];
    }
}
