<?php

namespace Tests\Feature;

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
        $response = $this->get('/show/product/1');
        $response->assertStatus(200);
        $response->assertSee('Go Back');
    }
}
