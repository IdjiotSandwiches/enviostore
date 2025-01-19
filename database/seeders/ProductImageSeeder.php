<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ProductImage::create([
            'url' => 'product_images/wool_jacket.jpg',
            'product_id' => 1,
        ]);

        ProductImage::create([
            'url' => 'product_images/wool_shirt.jpg',
            'product_id' => 2,
        ]);

        ProductImage::create([
            'url' => 'product_images/table.jpg',
            'product_id' => 3,
        ]);

        ProductImage::create([
            'url' => 'product_images/socks.jpg',
            'product_id' => 4,
        ]);

        ProductImage::create([
            'url' => 'product_images/chair.jpg',
            'product_id' => 5,
        ]);
    }
}
