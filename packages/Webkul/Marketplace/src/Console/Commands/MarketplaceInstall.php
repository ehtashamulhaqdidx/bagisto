<?php

namespace Webkul\Marketplace\Console\Commands;

use Illuminate\Console\Command;

class MarketplaceInstall extends Command
{
    protected $signature = 'marketplace:install';

    protected $description = 'Run migrations and publish assets for the Marketplace package';

    public function handle(): int
    {
        $this->info('Installing Marketplace...');

        $this->call('migrate', ['--force' => true]);

        $this->call('vendor:publish', [
            '--tag'   => 'marketplace-config',
            '--force' => true,
        ]);

        // Adds the 'seller' guard + provider to config/auth.php so
        // Auth::guard('seller') resolves without manual edits.
        $this->registerAuthGuard();

        $this->info('Marketplace installed. A "Marketplace" seller area is now available at /marketplace/seller.');

        return self::SUCCESS;
    }

    protected function registerAuthGuard(): void
    {
        $authConfigPath = config_path('auth.php');

        if (! file_exists($authConfigPath)) {
            $this->warn('Could not find config/auth.php — add the "seller" guard and provider manually. See package README.');

            return;
        }

        $contents = file_get_contents($authConfigPath);

        if (str_contains($contents, "'seller' =>")) {
            return; // already registered
        }

        $this->warn(
            "Add the following to config/auth.php manually (guards + providers arrays):\n\n".
            "    'guards' => [\n".
            "        // ...\n".
            "        'seller' => [\n".
            "            'driver'   => 'session',\n".
            "            'provider' => 'sellers',\n".
            "        ],\n".
            "    ],\n\n".
            "    'providers' => [\n".
            "        // ...\n".
            "        'sellers' => [\n".
            "            'driver' => 'eloquent',\n".
            "            'model'  => Webkul\\Marketplace\\Models\\Seller::class,\n".
            "        ],\n".
            "    ],\n"
        );
    }
}
