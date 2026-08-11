<?php

namespace Webkul\Marketplace\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\Marketplace\Http\Middleware\MarketplaceSellerMiddleware;
use Webkul\Marketplace\Http\Middleware\EnsureSellerIsApproved;

class MarketplaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerCommands();
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'marketplace');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'marketplace');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        // keep legacy alias if present
        $router->aliasMiddleware('marketplace.seller', MarketplaceSellerMiddleware::class);
        $router->aliasMiddleware('marketplace.seller.approved', EnsureSellerIsApproved::class);
    }

    /**
     * Register console commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            // $this->commands([]);
        }
    }
}
