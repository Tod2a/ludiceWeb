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
            'img_path' => function () {
                $absolutePath = fake()->image(storage_path('app/public/images'), 640, 480, 'cats', true);

                return str_replace(storage_path('app/public/'), '', $absolutePath);
            },
            'numberofplayers' => fake()->numberBetween(1, 10),
            'barcode' => fake()->unique()->numberBetween(1000, 9999),
            'duration' => fake()->numberBetween(15, 180),
            'suggestedage' => fake()->numberBetween(6, 99),
        ];
    }
}
