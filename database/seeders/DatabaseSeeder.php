<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Event;
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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed roles as per GODDOMPARK.md
        Role::insert([
            [
                'name' => 'Owner',
                'hierarchy_level' => 1,
                'color' => 'purple',
                'icon' => 'crown',
                'permissions' => json_encode(['all']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'hierarchy_level' => 2,
                'color' => 'red',
                'icon' => 'shield',
                'permissions' => json_encode(['admin']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff',
                'hierarchy_level' => 3,
                'color' => 'blue',
                'icon' => 'users',
                'permissions' => json_encode(['staff']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'hierarchy_level' => 4,
                'color' => 'green',
                'icon' => 'user',
                'permissions' => json_encode(['user']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed sample events
        Event::factory(5)->create();

        // Seed sample tokens
        $this->call([
            TokenSeeder::class,
        ]);
    }
}
