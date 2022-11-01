<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ManageProductTest extends TestCase
{
    public function test_to_store_product()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->actingAs($user, 'web')->post('/product', [
            'name' => 'Macbook Pro',
            'price' => '14000',
            'image' => $file
        ]);

        $response->assertRedirect('/product');
    }

    public function test_to_update_product()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('updated-product-image.jpg');

        $response = $this->actingAs($user, 'web')->patch('/product/' . $product->id, [
            'name' => 'Macbook Pro',
            'price' => '12000',
            'image' => $file
        ]);

        $response->assertRedirect('/product');
    }

    public function test_to_delete_product()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'web')->delete('/product/' . $product->id);

        $response->assertRedirect('/product');
    }
}
