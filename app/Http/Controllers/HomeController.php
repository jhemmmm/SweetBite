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
        $products = Product::where('quantity', '>', 0)->paginate(14);

        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function about(){
        return view('about');
    }

    public function product(Request $request)
    {
        $category_id = $request->category;
        if(!$category_id)
            abort(404);

        $categories = Category::get();
        $products = Product::where('category_id', $category_id)->where('quantity', '>', 0)->paginate(14);
        $cart = null;

        if(Auth::id())
            $cart = Cart::where('user_id', Auth::id())->count();
        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
            'cart_count' => $cart,
        ]);
    }

    public function productDetail($id){
        $product = Product::where('id', $id)->firstOrFail();

        return view('product.details', compact('product'));
    }
}
