<?php

namespace Verkdev\StripeBladeUi\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AutoInstallPackage extends Command
{
    protected $signature = 'stripeui:auto-install';

    protected $description = 'Install Stripe Blade UI';

    public function handle()
    {
        $this->info('Installing Stripe Blade UI...');

        Artisan::call('vendor:publish', [
            '--provider' => 'Verkdev\StripeBladeUi\StripeBladeUiServiceProvider',
            '--tag' => 'stripe-auto-setup',
            '--force' => true,
        ]);

        $mainRouteFile = base_path('routes/web.php');

        if (File::exists($mainRouteFile)) {

            $content = File::get($mainRouteFile);

            if (!str_contains($content, "require base_path('routes/stripe.php');")) {

                File::append(
                    $mainRouteFile,
                    PHP_EOL .
                    PHP_EOL .
                    "// StripeBladeUI" .
                    PHP_EOL .
                    "require base_path('routes/stripe.php');" .
                    PHP_EOL
                );
            }
        }

        $this->info('Stripe Blade UI installed successfully.');
    }
}
