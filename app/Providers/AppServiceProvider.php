<?php

namespace App\Providers;

use View;
use App\Sector;
use App\role;
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
        Schema::defaultStringLength(191);

        View::composer('*', function($view){
            $view->with('expense_menu', Sector::where('type', 0)->get());
            $view->with('income_menu', Sector::where('type', 1)->get());
            $view->with('role_menu', role::get());
        });
    }
}