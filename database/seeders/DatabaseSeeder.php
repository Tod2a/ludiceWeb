<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Creator;
use App\Models\Game;
use App\Models\Guest;
use App\Models\Mechanic;
use App\Models\Publisher;
use App\Models\ScoreSheet;
use App\Models\Section;
use App\Models\TemplateSection;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Category::factory(10)->create();
        Creator::factory(10)->create();
        Publisher::factory(10)->create();
        Mechanic::factory(10)->create();
        Game::factory(20)->create();
        TemplateSection::factory(10)->create();
        ScoreSheet::factory(2)->create();

        Game::all()->each(
            function ($game) {
                $game->categories()->attach(
                    Category::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray()
                );

                $game->mechanics()->attach(
                    Mechanic::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray()
                );

                $game->creators()->attach(
                    Creator::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray()
                );

                $game->publishers()->attach(
                    Publisher::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray()
                );
            }
        );

        $this->call([
            RoleSeeder::class,
            UserSeeder::class
        ]);

        Guest::factory(5)->create();
        Section::factory(20)->create();
    }
}
