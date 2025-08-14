<?php

namespace Tests;

use App\Brand;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_has_many_products()
    {
        $brand = Brand::factory()->create();
        Product::factory()->count(3)->create([
            'brand_id' => $brand->id
        ]);

        $this->assertCount(3, $brand->products);
        $this->assertInstanceOf(Product::class, $brand->products->first());
    }

    /** @test */
    public function active_scope_returns_only_active_brands()
    {
        Brand::factory()->count(2)->create(['status' => 'active']);
        Brand::factory()->create(['status' => 'inactive']);

        $activeBrands = Brand::active()->get();
        
        $this->assertCount(2, $activeBrands);
        $this->assertEquals(2, Brand::active()->count());
    }

    /** @test */
    public function inactive_scope_returns_only_inactive_brands()
    {
        Brand::factory()->count(1)->create(['status' => 'active']);
        Brand::factory()->count(3)->create(['status' => 'inactive']);

        $inactiveBrands = Brand::inactive()->get();
        
        $this->assertCount(3, $inactiveBrands);
        $this->assertEquals(3, Brand::inactive()->count());
    }
}
