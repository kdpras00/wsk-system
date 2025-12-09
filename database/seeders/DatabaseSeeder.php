<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@wsk.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Manager
        User::factory()->create([
            'name' => 'Production Manager',
            'email' => 'manager@wsk.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        // Operator
        User::factory()->create([
            'name' => 'Operator 1',
            'email' => 'operator@wsk.com',
            'password' => bcrypt('password'),
            'role' => 'operator',
        ]);
    }
}
