<?php

namespace App\Libraries;

use Illuminate\Support\ServiceProvider;

class ScryptServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['hash'] = $this->app->share(function ($app) {
            return new ScryptHash;
        });
    }

    public function provides()
    {
        return array('hash');
    }
}
