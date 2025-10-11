<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceRequest;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 7; $i++)
        {
            ServiceRequest::create([
                'client_id' => 2,
                'technician_id' => null,
                'category_id' => $i,
                'title' => 'Service Request ' . $i,
                'description' => 'This is a sample description for service request number ' . $i,
                'image' => null,
                'address' => 'Cairo, Egypt',
                'status' => 'pending',
                'completed_at' => null,
                'latitude' => 30.01045500,
                'longitude' => 31.33736060,
            ]);
        }
    }
}
