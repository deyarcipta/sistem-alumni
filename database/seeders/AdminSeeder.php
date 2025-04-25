<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'foto' => 'default.jpg',
            'role' => 'super user',
        ]);
    }
}

