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
            'img_path' => "storage/images/test.jpg",
            'numberofplayers' => fake()->numberBetween(1, 10),
            'barcode' => fake()->unique()->numberBetween(1000, 9999),
            'duration' => fake()->numberBetween(15, 180),
            'suggestedage' => fake()->numberBetween(6, 99),
        ];
    }
}
