<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Brand;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nike = Brand::where('name', 'Nike')->first();
        if ($nike) {
            Product::create([
                'brand_id' => $nike->id,
                'name' => 'Nike Air Max',
                'price' => 199.99,
                'currency' => 'USD',
                'status' => 'active',
                'custom_fields' => [
                    'color' => 'Black/White',
                    'size' => '40-45',
                    'category' => 'Running'
                ]
            ]);
        }

        $adidas = Brand::where('name', 'Adidas')->first();
        if ($adidas) {
            Product::create([
                'brand_id' => $adidas->id,
                'name' => 'Adidas Ultraboost',
                'price' => 179.99,
                'currency' => 'USD',
                'status' => 'active',
                'custom_fields' => [
                    'color' => 'Grey/White',
                    'size' => '40-45',
                    'category' => 'Running'
                ]
            ]);
        }

        $apple = Brand::where('name', 'Apple')->first();
        if ($apple) {
            Product::create([
                'brand_id' => $apple->id,
                'name' => 'Apple Gift Card',
                'price' => 100.00,
                'currency' => 'USD',
                'status' => 'active',
                'custom_fields' => [
                    'type' => 'Digital',
                    'region' => 'US',
                    'validity' => '12 months'
                ]
            ]);
        }
    }
}