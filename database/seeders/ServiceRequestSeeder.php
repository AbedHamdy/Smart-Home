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
        // بيانات أساسية مكررة
        $baseData = [
            'client_id' => 2,
            'technician_id' => 2,
            'category_id' => 2,
            'address' => 'Nasr City, Cairo, Egypt',
            'latitude' => 30.01038800,
            'longitude' => 31.33723700,
            'inspection_fee' => 150.00,
            'repair_cost' => null,
            'client_approved' => null,
        ];

        // 🛠️ إنشاء طلبين بالحالة in_progress
        ServiceRequest::create(array_merge($baseData, [
            'title' => 'Refrigerator not cooling',
            'description' => 'Customer reports that the refrigerator is not cooling properly.',
            'status' => 'in_progress',
            'technician_report' => 'Technician on the way to inspect.',
        ]));

        ServiceRequest::create(array_merge($baseData, [
            'title' => 'Washing machine not spinning',
            'description' => 'Customer reports that the washing machine is not spinning.',
            'status' => 'in_progress',
            'technician_report' => 'Inspection scheduled for today.',
        ]));

        // 🔧 إنشاء طلبين بالحالة assigned
        ServiceRequest::create(array_merge($baseData, [
            'title' => 'Air conditioner leaking water',
            'description' => 'Water leaking from indoor unit.',
            'status' => 'assigned',
            'technician_report' => 'Assigned to technician for inspection.',
        ]));

        ServiceRequest::create(array_merge($baseData, [
            'title' => 'Microwave not heating',
            'description' => 'Customer reports microwave runs but does not heat.',
            'status' => 'assigned',
            'technician_report' => 'Waiting for technician availability.',
        ]));
    }
}
