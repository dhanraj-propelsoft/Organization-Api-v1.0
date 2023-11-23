<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Http\Controllers\Api\Version_1\Interface\Organization\OrganizationInterface','App\Http\Controllers\Api\Version_1\Repositories\Organization\OrganizationRepository');
        $this->app->bind('App\Http\Controllers\Api\Version_1\Interface\Common\CommonInterface','App\Http\Controllers\Api\Version_1\Repositories\Common\CommonRepository');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
