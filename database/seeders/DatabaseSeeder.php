<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Test User12',
            'email' => 'test12@example.com',
            'username' => 'test12',
            'password' => bcrypt('12345'),
            'roles'  => 'user',
        ]);
    }
}
