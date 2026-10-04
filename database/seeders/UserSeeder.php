<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Admin Museum',
            'email' => 'admin@wasaka.com',
            'password' => Hash::make('password123'), // Passwordnya: password123
        ]);
    }
}