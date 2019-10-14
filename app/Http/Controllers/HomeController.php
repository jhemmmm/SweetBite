<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Cart;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $products = Product::paginate(14);
        $cart = null;

        if(Auth::id())
            $cart = Cart::where('user_id', Auth::id())->count();
        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
            'cart_count' => $cart,
        ]);
    }

    public function product(Request $request)
    {
        $category_id = $request->category;
        if(!$category_id)
            abort(404);

        $categories = Category::get();
        $products = Product::where('category_id', $category_id)->paginate(14);
        $cart = null;

        if(Auth::id())
            $cart = Cart::where('user_id', Auth::id())->count();
        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
            'cart_count' => $cart,
        ]);
    }
}
