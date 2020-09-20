<?php

namespace Dawilog\Laravel;

use Dawilog\Dawilog;
use Illuminate\Foundation\Application as Laravel;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public static $abstract = 'dawilog';


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/dawilog.php', 'dawilog');

        $this->app->singleton(static::$abstract, function ($app) {
            return new Dawilog($app);
        });
    }

    public function boot()
    {
        $this->app->make(static::$abstract);

        $this->publishes([
            __DIR__ . '/../../config/dawilog.php' => config_path('dawilog.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            static::$abstract
        ];
    }
}