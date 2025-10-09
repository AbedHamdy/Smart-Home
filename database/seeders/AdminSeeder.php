<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            'name' => 'abed',
            'email' => 'abed@abed.com',
            'password' => Hash::make('password123'),
            'phone' => '01000000001',
            'position' => 'CEO',
            'image' => null,
        ];

        $newAdmin = Admin::create([
            'position' => $admin['position'],
            'image' => $admin['image'],
        ]);

        $newUser = $newAdmin->user()->create([
            'name' => $admin['name'],
            'email' => $admin['email'],
            'password' => $admin['password'],
            'phone' => $admin['phone'],
            'role' => 'admin',
        ]);
    }
}
