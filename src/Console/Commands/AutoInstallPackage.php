<?php

namespace Verkdev\StripeBladeUi\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AutoInstallPackage extends Command
{
    // Yeh command ka naam hai
    protected $signature = 'stripeui:auto-install';
    protected $description = 'Automatically copies Stripe Controller, Views, Config, and Routes to user main folders';

    public function handle()
    {
        $this->info('Setting up Stripe Blade UI components...');

        // Yeh command chupke se bina user ko tang kiye files copy kar degi
        Artisan::call('vendor:publish', [
            '--provider' => 'Verkdev\StripeBladeUi\StripeBladeUiServiceProvider',
            '--tag' => 'stripe-auto-setup',
            '--force' => true // Agar pehle se file ho toh override kar de
        ]);

        $this->info('Stripe files successfully copied to your app, routes, views, and config folders!');
    }
}
