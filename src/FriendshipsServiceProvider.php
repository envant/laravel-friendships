<?php

namespace Envant\Friendships;

use Illuminate\Support\ServiceProvider;

class FriendshipsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadRoutes();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        if (config('friendships.routes.enabled') === true) {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/friendships.php', 'friendships');
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/friendships.php' => config_path('friendships.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations'),
        ], 'migrations');
    }
}
