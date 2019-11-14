<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Cart;
use Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::get();
        $products = Product::where('quantity', '>', 0);

        if($request->q){
            $products->where('title', 'LIKE', '%'.$request->q.'%');
        }

        $products = $products->paginate(14);


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
        $products = Product::where('category_id', $category_id)->where('quantity', '>', 0);

        if($request->q){
            $products->where('title', 'LIKE', '%'.$request->q.'%');
        }

        $products = $products->paginate(14);
        $cart = null;

        if(Auth::id())
            $cart = Cart::where('user_id', Auth::id())->count();
        return view('welcome', [
            'category' => $category_id,
            'categories' => $categories,
            'products' => $products,
            'cart_count' => $cart,
        ]);
    }

    public function productDetail($id){
        $product = Product::where('id', $id)->firstOrFail();

        return view('product.details', compact('product'));
    }

    public function cities(Request $request){
        $cities = resource_path('json/fulL_set.json');

        $cities = json_decode(file_get_contents($cities), true);

        $cities = collect($cities);

        return response()->json([
            'status' => true,
            'cities' => $cities->where('key', $request->province)->first()['cities']
        ]);

    }
}
