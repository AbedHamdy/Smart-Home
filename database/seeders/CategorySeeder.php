<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electrical Systems',
            'Security Systems',
            'HVAC (Heating, Ventilation, Air Conditioning)',
            'Home Automation / IoT',
            'Networking / Wi-Fi',
            'Plumbing & Water Systems',
            'Solar Energy Systems',
        ];

        foreach ($categories as $category)
        {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
