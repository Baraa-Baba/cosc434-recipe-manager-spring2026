<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Vegetarian',
            'Vegan',
            'Gluten-Free',
            'Dairy-Free',
            'Quick & Easy',
            'Healthy',
            'Low-Calorie',
            'Spicy',
            'Comfort Food',
            'Festive',
        ];

        foreach ($tags as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }
    }
}
