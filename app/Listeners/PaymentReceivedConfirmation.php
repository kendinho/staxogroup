<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Jobs\ChargeTheSecondHalfPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;

class PaymentReceivedConfirmation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PaymentReceived  $event
     * @return void
     */
    public function handle(PaymentReceived $event)
    {
        //send email confirmation
        Mail::to('adubyte2@yahoo.com')->send(new PaymentConfirmation($event->buyer, $event->product, $event->price));
        ChargeTheSecondHalfPayment::dispatchIf($event->paymentMethod, $event->buyer, $event->product, $event->price, $event->paymentMethod)->delay(now()->addMinutes(5));
    }
}
