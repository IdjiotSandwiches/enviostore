<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::create([
            'name' => 'Jacket',
            'description' => 'Sustainable jacket from wools',
            'price' => 250.000,
            'stocks' => 20,
            'category_id' => 1,
            'sustainability_score' => 4.5,
        ]);

        Product::create([
            'name' => 'Shirt',
            'description' => 'Sustainable shirt from wools',
            'price' => 100.000,
            'stocks' => 15,
            'category_id' => 1,
            'sustainability_score' => 4.8,
        ]);

        Product::create([
            'name' => 'Table',
            'description' => 'Sustainable table',
            'price' => 450.000,
            'stocks' => 10,
            'category_id' => 2,
            'sustainability_score' => 4.8,
        ]);

        Product::create([
            'name' => 'Socks',
            'description' => 'Sustainable socks from wools',
            'price' => 50.000,
            'stocks' => 15,
            'category_id' => 2,
            'sustainability_score' => 4.1,
        ]);

        Product::create([
            'name' => 'Chair',
            'description' => 'Sustainable chair',
            'price' => 300.000,
            'stocks' => 5,
            'category_id' => 2,
            'sustainability_score' => 4.8,
        ]);
    }
}
