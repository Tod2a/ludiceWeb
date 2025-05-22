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

        $adminUser = User::factory()->create([
            'name' => 'Admin2 User',
            'email' => 'admin2@example.com',
            'role_id' => 2,
        ]);

        $adminUser = User::factory()->create([
            'name' => 'Admin3 User',
            'email' => 'admin3@example.com',
            'role_id' => 2,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User1',
            'email' => 'user1@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User2',
            'email' => 'user2@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User3',
            'email' => 'user3@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User4',
            'email' => 'user4@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User5',
            'email' => 'user5@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User6',
            'email' => 'user6@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User7',
            'email' => 'user7@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User8',
            'email' => 'user8@example.com',
            'role_id' => 3,
        ]);

        $regularUser = User::factory()->create([
            'name' => 'User9',
            'email' => 'user9@example.com',
            'role_id' => 3,
        ]);

        $game = Game::first();

        if ($game) {
            $regularUser->library()->attach($game->id, ['added_at' => now()]);
        } else {
            $this->command->warn('no games in database');
        }
    }
}
