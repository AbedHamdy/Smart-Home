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
            ['name' => 'Electrical Systems', 'price' => 250],
            ['name' => 'Security Systems', 'price' => 300],
            ['name' => 'HVAC (Heating, Ventilation, Air Conditioning)', 'price' => 350],
            ['name' => 'Home Automation / IoT', 'price' => 400],
            ['name' => 'Networking / Wi-Fi', 'price' => 200],
            ['name' => 'Plumbing & Water Systems', 'price' => 220],
            ['name' => 'Solar Energy Systems', 'price' => 450],
        ];

        foreach ($categories as $category)
        {
            Category::create($category);
        }
    }

}
