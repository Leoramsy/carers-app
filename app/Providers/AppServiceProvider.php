<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * https://laravel.com/docs/5.4/migrations
         * #Index Lengths & MySQL / MariaDB
         * Issue with Laravel 5.4 & MySQL versions older than 5.7.7
         */
        Schema::defaultStringLength(191);
        /*
         * Let Laravel know about the new folders in the migrations structure!
         */
        $this->loadMigrationsFrom('database/migrations/create/*'); //New tables
    }
}
