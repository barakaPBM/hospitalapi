<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $products = [
            'Paracetamol Tablets',
            'Ibuprofen Gel',
            'Amoxicillin Capsules',
            'Digital Thermometer',
            'Blood Pressure Monitor',
            'Antiseptic Wound Spray',
            'Insulin Pen',
            'Surgical Gloves (Latex-Free)',
            'Disposable Face Masks (Pack of 50)',
            'Cough Syrup (Honey & Lemon)',
        ];

        foreach ($products as $name) {
            DB::table('products')->insert([
                'name' => $name,
                'description' => null,
                'price' => fake()->randomFloat(2, 5, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
