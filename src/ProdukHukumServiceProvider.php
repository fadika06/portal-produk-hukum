<?php

namespace Bantenprov\ProdukHukum;

use Illuminate\Support\ServiceProvider;
use Bantenprov\ProdukHukum\Console\Commands\ProdukHukumCommand;

/**
 * The ProdukHukumServiceProvider class
 *
 * @package Bantenprov\ProdukHukum
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdukHukumServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
        $this->seedHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('produk-hukum', function ($app) {
            return new ProdukHukum;
        });

        $this->app->singleton('command.produk-hukum', function ($app) {
            return new ProdukHukumCommand;
        });

        $this->commands('command.produk-hukum');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'produk-hukum',
            'command.produk-hukum',
        ];
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('produk-hukum.php');

        $this->mergeConfigFrom($packageConfigPath, 'produk-hukum');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'produk-hukum-config');
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'produk-hukum');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/produk-hukum'),
        ], 'produk-hukum-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'produk-hukum');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/produk-hukum'),
        ], 'produk-hukum-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], 'produk-hukum-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'produk-hukum-migrations');
    }

    public function publicHandle()
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], 'produk-hukum-public');
    }

    public function seedHandle()
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], 'produk-hukum-seeds');
    }
}
