<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; //NEW: Import Schema
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

       /* if (true) {
            \DB::listen(function ($query) {
                \Log::info(
                    $query->sql, $query->bindings, $query->time
                );
            });
        }*/
        Schema::defaultStringLength(191); //NEW: Increase StringLength
    }
}
