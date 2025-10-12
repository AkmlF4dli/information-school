<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
    'picture' => '/storage/profile/profile.jpg',
    'identity' => 1,
    'name' => 'Admin',
    'email' => 'info@smkn8jakarta.sch.id',
    'password' => Hash::make('smkn8'), // hashed password
    'role' => 'admin',
    'remember_token' => null, 
]);

User::factory()->create([
    'picture' => '/storage/profile/profile.jpg',
    'identity' => 2,
    'name' => 'Kesiswaan',
    'email' => 'kesiswaan@smkn8jakarta.sch.id',
    'password' => Hash::make('smkn8'), // hashed password
    'role' => 'kesiswaan',
    'remember_token' => null, 
]);
    }
}
