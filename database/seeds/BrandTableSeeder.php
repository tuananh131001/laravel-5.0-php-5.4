<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'name' => 'Nike',
            'status' => 'active',
            'custom_fields' => [
                'category' => 'Sports',
                'region' => 'Global'
            ]
        ]);

        Brand::create([
            'name' => 'Adidas',
            'status' => 'active',
            'custom_fields' => [
                'category' => 'Sports',
                'region' => 'Global'
            ]
        ]);

        Brand::create([
            'name' => 'Apple',
            'status' => 'active',
            'custom_fields' => [
                'category' => 'Technology',
                'region' => 'Global'
            ]
        ]);
    }
}