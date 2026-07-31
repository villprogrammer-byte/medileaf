<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@medileaf.com'], // <-- yahan apna admin email daalen
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@123'), // <-- yahan apna password daalen
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}