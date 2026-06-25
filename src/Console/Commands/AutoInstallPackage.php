<?php

namespace Verkdev\StripeBladeUi\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AutoInstallPackage extends Command
{
    protected $signature = 'stripeui:auto-install';
    protected $description = 'Automatically copies Stripe Controller, Views, Config, and Routes to user main folders';

    public function handle()
    {
        $this->info('Setting up Stripe Blade UI components...');

        Artisan::call('vendor:publish', [
            '--provider' => 'Verkdev\StripeBladeUi\StripeBladeUiServiceProvider',
            '--tag' => 'stripe-auto-setup',
            '--force' => true
        ]);

        $mainRouteFile = base_path('routes/web.php');
        if (File::exists($mainRouteFile)) {
            $currentRouteContent = File::get($mainRouteFile);

            if (!str_contains($currentRouteContent, 'stripe.checkout')) {
                $packageRoutes = File::get(__DIR__.'/../../routes/web.php');

                $packageRoutesClean = str_replace(['<?php', '?>'], '', $packageRoutes);

                File::append($mainRouteFile, "\n\n// Added by stripebaldeui package\n" . $packageRoutesClean);
            }
        }

        $this->info('Stripe files successfully copied to your app, routes, views, and config folders!');
    }
}
