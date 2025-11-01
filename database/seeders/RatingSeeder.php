<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\Client;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technicians = Technician::all();
        $clients = Client::all();
        $serviceRequests = ServiceRequest::all();

        // لو مفيش داتا متولدة قبل كده
        if ($technicians->isEmpty() || $clients->isEmpty() || $serviceRequests->isEmpty())
        {
            $this->command->warn("⚠️ تأكد من تشغيل ClientSeeder وTechnicianSeeder وServiceRequestSeeder أولًا.");
            return;
        }

        // توليد 10 تقييمات عشوائية
        for ($i = 0; $i < 10; $i++)
            {
            $technician = $technicians->random();
            $client = $clients->random();
            $serviceRequest = $serviceRequests->random();

            Rating::create([
                'service_request_id' => $serviceRequest->id,
                'technician_id' => $technician->id,
                'client_id' => $client->id,
                'rating' => rand(3, 5), // تقييم من 3 إلى 5 نجوم
                'comment' => fake()->sentence(8),
            ]);
        }

        $this->command->info("✅ 10 reviews successfully created!");
    }
}
