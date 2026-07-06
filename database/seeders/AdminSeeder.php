<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', 'Admin')->exists()) {
            return;
        }

        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@sitani.local',
            'password' => Hash::make('AdminSiTani!123'),
            'role' => 'Admin',
        ]);
    }
}
