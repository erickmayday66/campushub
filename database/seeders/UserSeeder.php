<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@campushub.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Manager
        User::create([
            'name' => 'Election Manager',
            'email' => 'manager@campushub.com',
            'password' => Hash::make('manager123'),
            'role' => 'manager',
        ]);
    }
}
