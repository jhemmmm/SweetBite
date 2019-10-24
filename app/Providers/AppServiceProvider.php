<?php

namespace App\Providers;

use App\Category;
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
        view()->composer('layouts.app', function($view){
            $categories = Category::all();
            $view->with('categories', $categories);
        });
        view()->composer('layouts.setting', function($view){
            $categories = Category::all();
            $view->with('categories', $categories);
        });
    }
}
