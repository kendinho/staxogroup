<?php

namespace App\Http\Controllers;

use App\Events\PaymentReceived;
use Illuminate\Http\Request;
use App\Models\Buyer;
use App\Models\Product;


class StripePaymentController extends Controller

{
    public function collect_buyer_info($id)
    {
        return view('collect-buyer-info', [
            'product' => Product::findorFail($id)
        ]);
    }

    public function store_buyer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required | max:255',
            'email' => 'required | email | max:255'
        ]);

        $buyer = Buyer::create($request->all());

        return to_route('go-to-payment', [
            'id' => $buyer->id,
            'product_id' => $id
        ]);
    }

    public function charge($id, $product_id)
    {
        $buyer = Buyer::findorFail($id);
        $product = Product::findorFail($product_id);

        return view('payment', [
            'buyer' => $buyer,
            'intent' => $buyer->createSetupIntent(),
            'product' => $product
        ]);
    }

    public function process_payment(Request $request, $id)
    {
        $buyer = Buyer::findorFail($request->buyer_id);
        $product = Product::findorFail($id);

        $paymentMethod = $request->input('payment_method');

        $buyer->createOrGetStripeCustomer();

        $buyer->addPaymentMethod($paymentMethod);

        try {

            //Changing the initial payment to half the price
            $price = round($product->price / 2);

            $charge = $buyer->charge(($price * 100), $paymentMethod);

            if ($charge) {
                event(new PaymentReceived($buyer, $product->name, $price, $paymentMethod));
            }
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error charging card. ' . $e->getMessage()]);
        }
        return view('thank-you', ['user' => $buyer]);
    }
}
