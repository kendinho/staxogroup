<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_catalog_route_to_ensure_products_display()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('View Product');
    }

    public function test_single_product_route()
    {
        $product = Product::factory()->create();
        $response = $this->get('/show/product/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee('Go Back');
    }

    public function test_unauthorised_access_to_products_table()
    {
        $response = $this->get('/product');
        $response->assertRedirect('/login');
    }

    public function test_authorised_access_to_products_table()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'web')->get('/product');
        $response->assertStatus(200);
        $response->assertSee('Edit');
    }

    public function test_go_to_create_product_route()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'web')->get('/product/create');
        $response->assertStatus(200);
        $response->assertSee('Add Product');
    }

    public function test_go_to_edit_product_route()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'web')->get('/product/' . $product->id . '/edit');
        $response->assertStatus(200);
        $response->assertSee('Edit Product');
    }

    public function test_route_to_identify_buyer()
    {
        $product = Product::factory()->create();
        $response = $this->get('/identify/buyer/' . $product->name . '/' . $product->price);
        $response->assertStatus(200);
        $response->assertSee('Buyer Email');
    }
}
