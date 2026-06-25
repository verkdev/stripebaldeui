<?php

namespace Verkdev\StripeBladeUi;

use Illuminate\Support\ServiceProvider;
use Verkdev\StripeBladeUi\Console\Commands\AutoInstallPackage;

class StripeBladeUiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/stripe.php', 'stripe');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AutoInstallPackage::class,
            ]);

            $this->publishes([
                __DIR__.'/resources/views/stripe.blade.php' => resource_path('views/stripe.blade.php'),
                __DIR__.'/Http/Controllers/StripePaymentController.php' => app_path('Http/Controllers/StripePaymentController.php'),
                __DIR__.'/../config/stripe.php' => config_path('stripe.php'),
            ], 'stripe-auto-setup');
        }

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'stripebaldeui');
    }
}
