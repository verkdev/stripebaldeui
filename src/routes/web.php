<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;

Route::middleware(['web'])->group(function () {

    Route::get('stripe', [StripePaymentController::class, 'index'])
        ->name('stripe.index');

    Route::post('stripe/checkout', [StripePaymentController::class, 'checkout'])
        ->name('stripe.checkout');

    Route::get('stripe/success', [StripePaymentController::class, 'success'])
        ->name('stripe.success');
});
