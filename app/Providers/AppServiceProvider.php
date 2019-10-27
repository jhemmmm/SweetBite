<?php

namespace App\Providers;

use App\Cart;
use App\Category;
use Illuminate\Support\Facades\Auth;
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

            $cart = null;
            if(Auth::id())
                $cart = Cart::where('user_id', Auth::id())->count();

            $view->with([
                'categories' => $categories,
                'cart_count' => $cart
            ]);
        });
        view()->composer('layouts.setting', function($view){
            $categories = Category::all();

            $cart = null;
            if(Auth::id())
                $cart = Cart::where('user_id', Auth::id())->count();

            $view->with([
                'categories' => $categories,
                'cart_count' => $cart
            ]);
        });
    }
}
