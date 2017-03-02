<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserAccessServiceProvider extends ServiceProvider
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
            \App\Repositories\UsersAccessRights\UsersAccessRightsRepositoryContract::class,
            \App\Repositories\UsersAccessRights\UsersAccessRightsRepository::class
        );
    }
}
