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
        // Regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // ✅ Admin user
        User::create([
            'name'     => 'Sreymom',           // ✏️ change to your name
            'email'    => 'sreymom@admin.gmail.com', // ✏️ change to your email
            'password' => bcrypt('mom123'), // ✏️ change to your password
            'is_admin' => 1,
        ]);
    }
}
