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
        $this->loadMigrationsFrom([database_path('migrations') . '/initial']); //New tables //database/migrations
        $this->loadMigrationsFrom([database_path('migrations') . '/revisions/*']); //Revised database //database/migrations
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

        view()->composer('layouts.navbars.navbar', function ($view) {
            $user = auth()->user();
            $initials = '';
            $image = NULL;
            if (!is_null($user)) {
                $initials = substr($user->name, 0, 1) . substr($user->surname, 0, 1);
            }
            $view->with(['initials' => $initials, 'image' => $image]);
        });
    }
}
