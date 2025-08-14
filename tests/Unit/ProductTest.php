<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Product;
use App\Brand;
use App\Card;
use App\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'Test description',
            'price' => 1000,
            'status' => 'active',
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals('Test description', $product->description);
        $this->assertEquals(1000, $product->price);
        $this->assertEquals('active', $product->status);
    }

    /** @test */
    public function it_belongs_to_a_brand()
    {
        $brand = Brand::factory()->create();
        $product = Product::factory()->create(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Brand::class, $product->brand);
        $this->assertEquals($brand->id, $product->brand->id);
    }

    /** @test */
    public function it_has_many_cards()
    {
        $product = Product::factory()->create();
        $cards = Card::factory()->count(3)->create(['product_id' => $product->id]);

        $this->assertInstanceOf(Card::class, $product->cards->first());
        $this->assertCount(3, $product->cards);
    }

    /** @test */
    public function it_belongs_to_many_clients()
    {
        $product = Product::factory()->create();
        $clients = Client::factory()->count(2)->create();
        $product->clients()->attach($clients);

        $this->assertInstanceOf(Client::class, $product->clients->first());
        $this->assertCount(2, $product->clients);
    }

    /** @test */
    public function it_can_scope_active_products()
    {
        Product::factory()->active()->create();
        Product::factory()->inactive()->create();

        $activeProducts = Product::active()->get();
        $this->assertCount(1, $activeProducts);
        $this->assertEquals('active', $activeProducts->first()->status);
    }

    /** @test */
    public function it_can_scope_inactive_products()
    {
        Product::factory()->active()->create();
        Product::factory()->inactive()->create();

        $inactiveProducts = Product::inactive()->get();
        $this->assertCount(1, $inactiveProducts);
        $this->assertEquals('inactive', $inactiveProducts->first()->status);
    }

    /** @test */
    public function it_can_toggle_status()
    {
        $product = Product::factory()->active()->create();
        $product->toggleStatus();
        $this->assertEquals('inactive', $product->status);

        $product->toggleStatus();
        $this->assertEquals('active', $product->status);
    }
}
