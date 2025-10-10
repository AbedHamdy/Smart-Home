<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientsData = [
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed.hassan@example.com',
                'password' => 'password123',
                'phone' => '01012345678',
                'address' => 'شارع الثورة، القاهرة، مصر',
                // 'latitude' => 30.0444,
                // 'longitude' => 31.2357,
            ],
            [
                'name' => 'Mona Ali',
                'email' => 'mona.ali@example.com',
                'password' => 'password123',
                'phone' => '01122334455',
                'address' => 'شارع فيصل، الجيزة، مصر',
                // 'latitude' => 29.9869,
                // 'longitude' => 31.1626,
            ],
            [
                'name' => 'Omar Khaled',
                'email' => 'omar.khaled@example.com',
                'password' => 'password123',
                'phone' => '01233445566',
                'address' => 'كورنيش الإسكندرية، الإسكندرية، مصر',
                // 'latitude' => 31.2001,
                // 'longitude' => 29.9187,
            ],
        ];

        foreach ($clientsData as $data) {
            $client = Client::create([
                'address' => $data['address'],
                // 'latitude' => $data['latitude'],
                // 'longitude' => $data['longitude'],
            ]);

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'role' => 'client',
                'userable_id' => $client->id,
                'userable_type' => Client::class,
            ]);
        }
    }
}
