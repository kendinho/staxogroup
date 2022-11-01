<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Buyer;
use App\Events\PaymentReceived;

class ChargeTheSecondHalfPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $buyer;
    public $product;
    public $price;
    public $paymentMethod;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Buyer $buyer, $product, $price, $paymentMethod)
    {
        $this->buyer = $buyer;
        $this->product = $product;
        $this->price = $price;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $charge = $this->buyer->charge(($this->price * 100), $this->paymentMethod);
        if ($charge) {
            event(new PaymentReceived($this->buyer, $this->product, $this->price, false));
        }
    }
}
