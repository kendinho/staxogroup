<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class PaymentReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $buyer;
    public $product;
    public $price;
    public $paymentMethod;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($buyer, $product, $price, $paymentMethod)
    {
        $this->buyer = $buyer;
        $this->product = $product;
        $this->price = $price;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
