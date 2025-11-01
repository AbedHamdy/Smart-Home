<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TechnicianApplication;

class TechnicianApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technicians = [
            ['name' => 'Ahmed Hassan', 'email' => 'ahmed.hasan@example.com', 'phone' => '01012345678'],
            // ['name' => 'Mohamed Ali', 'email' => 'mohamed.ali@example.com', 'phone' => '01087654321'],
            ['name' => 'Sara Ibrahim', 'email' => 'sara.ibrahim@example.com', 'phone' => '01123456789'],
            ['name' => 'Omar Youssef', 'email' => 'omar.youssef@example.com', 'phone' => '01234567890'],
            ['name' => 'Hana Mahmoud', 'email' => 'hana.mahmoud@example.com', 'phone' => '01198765432'],
            ['name' => 'Khaled Mostafa', 'email' => 'khaled.mostafa@example.com', 'phone' => '01055554444'],
            ['name' => 'Nour Adel', 'email' => 'nour.adel@example.com', 'phone' => '01266667777'],
            ['name' => 'Yara Tarek', 'email' => 'yara.tarek@example.com', 'phone' => '01133332222'],
        ];

        foreach ($technicians as $index => $tech)
        {
            TechnicianApplication::create([
                'name' => $tech['name'],
                'email' => $tech['email'],
                'phone' => $tech['phone'],
                'category_id' => $index + 1,
                'skills' => 'Electrical installation, wiring, maintenance, troubleshooting',
                'experience' => rand(1, 10),
                'cv_file' => 'cvs/1760104246_66909.docx',
                'status' => 'pending',
                'notes' => 'Looking forward to joining Khedmaty team.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
