<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    public function index()
    {
        $stripeKey = config('stripe.key') ?? env('STRIPE_KEY');

        return view('stripe', compact('stripeKey'));
    }

    public function checkout(Request $request)
    {
        $stripeSecret = config('stripe.secret') ?? env('STRIPE_SECRET');

        if (!$stripeSecret) {
            return response()->json([
                'status' => false,
                'message' => 'Stripe Secret Key missing'
            ]);
        }

        Stripe::setApiKey($stripeSecret);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Sample Payment',
                    ],
                    'unit_amount' => 1000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.index'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return 'Payment Successful!';
    }
}
