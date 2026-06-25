<?php

namespace Verkdev\StripeBladeUi\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController
{
    public function index()
    {
        // View ko stripe key pass kar rahe hain agar future me blade me js checkout use karni ho
        $stripeKey = config('stripe.key') ?? env('STRIPE_KEY');

        return view('stripebaldeui::stripe', compact('stripeKey'));
    }

    public function checkout(Request $request)
    {
        // Pehle config se check karega, agar wahan nahi mili toh direct env se uthaye ga
        $stripeSecret = config('stripe.secret') ?? env('STRIPE_SECRET');

        if (!$stripeSecret) {
            return "Stripe Secret Key missing! Please add STRIPE_SECRET in your .env file.";
        }

        // Stripe SDK ko secret key assign kar rahe hain
        Stripe::setApiKey($stripeSecret);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Sample Package Payment',
                    ],
                    'unit_amount' => 1000, // $10.00 (Amount cents me hoti hai)
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
