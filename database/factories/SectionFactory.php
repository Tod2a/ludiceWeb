<?php

namespace Database\Factories;

use App\Models\Guest;
use App\Models\ScoreSheet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $scoreSheetId = ScoreSheet::inRandomOrder()->first()->id;
        $guestId = rand(0, 1) ? Guest::inRandomOrder()->first()->id : null;
        $userId = $guestId ? null : User::inRandomOrder()->first()->id;

        return [
            'score_sheet_id' => $scoreSheetId,
            'guest_id' => $guestId,
            'user_id' => $userId,
            'score' => $this->faker->numberBetween(1, 100),
        ];
    }
}
