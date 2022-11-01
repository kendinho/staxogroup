<?php

namespace Tests\Feature;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProcessPaymentTest extends TestCase
{
    /**
     * Feature testing Payment Processing.
     *
     * @return void
     */
    public function test_to_store_buyer()
    {
        $product = Product::factory()->create();
        $response = $this->post('/store/buyer/' . $product->name . '/' . $product->price, [
            'name' => 'Kenneth Adubobi',
            'email' => 'adubyte2@yahoo.com'
        ]);
        $response->assertStatus(302);
        $response->assertRedirectContains('/payment');
    }

    public function test_to_process_payment()
    {
        $product = Product::factory()->create();
        $buyer = Buyer::factory()->create();

        $response = $this->post('/process/payment/' . $product->name . '/' . $product->price, [

            'buyer_id' => $buyer->id,
            'payment_method' => "pm_1LzPr9EuXpONo64EUUmxm6Bd"
        ]);

        $response->assertSee('Thank you');
    }
}
