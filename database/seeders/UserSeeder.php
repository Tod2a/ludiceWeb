<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masterUser = User::factory()->create([
            'name' => 'master User',
            'email' => 'master@example.com',
            'role_id' => 1,
        ]);

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_id' => 2,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'role_id' => 3,
        ]);

        $game = Game::first();

        if ($game) {
            $regularUser->libraryGames()->attach($game->id, ['added_at' => now()]);
        } else {
            $this->command->warn('no games in database');
        }
    }
}
