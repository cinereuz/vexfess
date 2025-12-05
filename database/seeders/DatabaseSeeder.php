<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 Akun Admin Khusus
        User::create([
            'name' => 'Admin',
            'email' => 'admin@menfess.com', // Email Login Admin
            'password' => Hash::make('kocak6_'), // Password Admin
            'is_admin' => true, // Tandai sebagai Admin
        ]);
    }
}