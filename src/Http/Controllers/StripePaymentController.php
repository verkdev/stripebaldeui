<?php

namespace Verkdev\StripeBladeUi\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController
{
    public function index()
    {
        $stripeKey = config('stripe.key') ?? env('STRIPE_KEY');

        return view('stripebaldeui::stripe', compact('stripeKey'));
    }

    public function checkout(Request $request)
    {
        $stripeSecret = config('stripe.secret') ?? env('STRIPE_SECRET');

        if (!$stripeSecret) {
            return "Stripe Secret Key missing! Please add STRIPE_SECRET in your .env file.";
        }

        Stripe::setApiKey($stripeSecret);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Sample Package Payment',
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
        return "Payment Successful! Thank you for using stripebaldeui.";
    }
}
