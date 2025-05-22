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

        $adminUsers = [
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role_id' => 2,
            ]),
            User::factory()->create([
                'name' => 'Admin2 User',
                'email' => 'admin2@example.com',
                'role_id' => 2,
            ]),
            User::factory()->create([
                'name' => 'Admin3 User',
                'email' => 'admin3@example.com',
                'role_id' => 2,
            ]),
        ];

        $regularUsers = [];
        for ($i = 1; $i <= 9; $i++) {
            $regularUsers[] = User::factory()->create([
                'name' => 'User' . $i,
                'email' => 'user' . $i . '@example.com',
                'role_id' => 3,
            ]);
        }

        $game = Game::first();

        if ($game) {
            foreach ($regularUsers as $user) {
                $user->library()->attach($game->id, ['added_at' => now()]);
            }
        } else {
            $this->command->warn('no games in database');
        }
    }
}
