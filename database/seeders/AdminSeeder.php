<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'admin_id' => 'ADM001',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'role' => 'admin',
        ]);
    }
}
