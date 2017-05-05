<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\ContactDetails\ContactDetailsInterface::class,
            \App\Repositories\ContactDetails\ContactDetails::class
        );
    }
}
