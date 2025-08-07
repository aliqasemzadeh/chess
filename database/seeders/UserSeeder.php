<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 fake users
        User::factory(10)->create();

        // Create a default admin user
        User::create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
