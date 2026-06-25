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
                __DIR__.'/resources/views' => resource_path('views'),
                __DIR__.'/routes' => base_path('routes'),
                __DIR__.'/Http/Controllers' => app_path('Http/Controllers'),
                __DIR__.'/../config' => config_path(),
            ], 'stripe-auto-setup');
        }
    }
}
