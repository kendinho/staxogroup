<?php

namespace App\Http\Controllers;

use App\Events\PaymentReceived;
use Illuminate\Http\Request;
use App\Models\Buyer;


class StripePaymentController extends Controller

{
    public function collect_buyer_info(String $product, $price)
    {
        return view('collect-buyer-info', [
            'product' => $product,
            'price' => $price
        ]);
    }

    public function store_buyer(Request $request, String $product, $price)
    {
        $request->validate([
            'name' => 'required | max:255',
            'email' => 'required | email | max:255'
        ]);

        $buyer = Buyer::create($request->all());
        return redirect()->route('go-to-payment', [
            'id' => $buyer->id,
            'product' => $product,
            'price' => $price
        ]);
    }

    public function charge($id, String $product, $price)
    {
        $buyer = Buyer::findorFail($id);

        return view('payment', [
            'buyer' => $buyer,
            'intent' => $buyer->createSetupIntent(),
            'product' => $product,
            'price' => $price
        ]);
    }

    public function process_payment(Request $request, String $product, $price)
    {
        $buyer = Buyer::findorFail($request->buyer_id);

        $paymentMethod = $request->input('payment_method');

        $buyer->createOrGetStripeCustomer();

        $buyer->addPaymentMethod($paymentMethod);

        try {

            //Changing the initial payment to half the price
            $price = round($price / 2);

            $charge = $buyer->charge(($price * 100), $paymentMethod);

            if ($charge) {
                event(new PaymentReceived($buyer, $product, $price, $paymentMethod));
            }
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error charging card. ' . $e->getMessage()]);
        }
        return view('thank-you', ['user' => $buyer]);
    }
}
