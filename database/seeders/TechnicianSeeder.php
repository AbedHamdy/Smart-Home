<?php

namespace Database\Seeders;

use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $techniciansData = [
            [
                'name' => 'Ali Mahmoud',
                'email' => 'ali.mahmoud@example.com',
                'password' => 'password123',
                'phone' => '01098765432',
                'category_id' => 1, // تأكد ان التخصص موجود في جدول categories
                'experience_years' => 5,
                'availability_status' => 'available',
                'rating' => 4.5,
            ],
            [
                'name' => 'Sara Adel',
                'email' => 'sara.adel@example.com',
                'password' => 'password123',
                'phone' => '01111222333',
                'category_id' => 2,
                'experience_years' => 3,
                'availability_status' => 'busy',
                'rating' => 4.2,
            ],
            [
                'name' => 'Mohamed Samir',
                'email' => 'mohamed.samir@example.com',
                'password' => 'password123',
                'phone' => '01222333444',
                'category_id' => 1,
                'experience_years' => 7,
                'availability_status' => 'offline',
                'rating' => 4.8,
            ],
        ];

        foreach ($techniciansData as $data) {
            $technician = Technician::create([
                'category_id' => $data['category_id'],
                'experience_years' => $data['experience_years'],
                'availability_status' => $data['availability_status'],
                'rating' => $data['rating'],
            ]);

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'role' => 'technician',
                'userable_id' => $technician->id,
                'userable_type' => Technician::class,
            ]);
        }
    }
}
