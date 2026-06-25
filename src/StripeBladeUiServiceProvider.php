<?php

namespace Verkdev\StripeBladeUi;

use Illuminate\Support\ServiceProvider;

class StripeBladeUiServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Stripe config publish karne ke liye
        $this->mergeConfigFrom(__DIR__.'/../config/stripe.php', 'stripe');
    }

    public function boot()
    {
        // 1. Routes Load Karein
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // 2. Views Load Karein (Namespace: stripebaldeui)
        $this->loadViewsFrom(__DIR__.'/resources/views', 'stripebaldeui');

        // 3. Asset/Config publishing
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/resources/views' => resource_path('views/vendor/stripebaldeui'),
            ], 'stripe-views');

            $this->publishes([
                __DIR__.'/../config/stripe.php' => config_path('stripe.php'),
            ], 'stripe-config');
        }
    }
}
