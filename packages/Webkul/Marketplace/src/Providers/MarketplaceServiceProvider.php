<?php

namespace Webkul\Marketplace\Providers;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\Marketplace\Console\Commands\MarketplaceInstall;
use Webkul\Marketplace\Http\Middleware\Seller as SellerMiddleware;
use Webkul\Marketplace\Listeners\GenerateCommission;

class MarketplaceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/marketplace.php', 'marketplace');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/seller-routes.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/admin-routes.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'marketplace');
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'marketplace');

        $this->publishes([
            __DIR__.'/../Config/marketplace.php' => config_path('marketplace.php'),
        ], 'marketplace-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                MarketplaceInstall::class,
            ]);
        }

        $this->registerMiddleware();
        $this->registerEventListeners();
    }

    protected function registerMiddleware(): void
    {
        

        Route::aliasMiddleware('marketplace.seller', SellerMiddleware::class);
    }

    /**
     * Binds commission generation to Bagisto's invoice-creation event.
     * If your installed Bagisto version fires a differently named event
     * for invoice creation, update the event name string below to match.
     */
    protected function registerEventListeners(): void
    {
        Event::listen('sales.invoice.save.after', [GenerateCommission::class, 'handle']);
    }
}
