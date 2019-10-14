<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Cart;
use App\Order;
use App\OrderProduct;
use Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['product'])->where('user_id', Auth::id())->get();
        
        $categories = Category::get();
        $cart = null;

        if(Auth::id())
            $cart = Cart::where('user_id', Auth::id())->count();
        
        $total_price = 0;
        
        return view('cart', [
            'categories' => $categories,
            'carts' => $carts,
            'cart_count' => $cart,
            'total_price' => $total_price,
        ]);
    }

    public function addItem(Request $request)
    {
        if(!Auth::id())
            return redirect()->route('login');

        $id = $request->id;
        if(!$id)
            return redirect()->route('cart');

        $product = Product::where('id', $id)->first();
        if(!$product)
            return redirect()->route('cart');

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();
        if(!$cart){
            $cart = new Cart;
            $cart->user_id = Auth::id();
            $cart->product_id = $id;
            $cart->quantity = 1;
        }else{
            $cart->quantity++;
        }
        $cart->save();

        return redirect()->route('cart');
    }

    public function orderItem(Request $request)
    {
        $product_ids = $request->product_ids;
        $product_quantities = $request->product_quantities;
        $total_price = $request->total_price;

        $new_order = new Order;
        $new_order->user_id = Auth::id();
        $new_order->address_id = 0;
        $new_order->paid_price = $total_price;
        $new_order->status = 0;
        $new_order->save();

        foreach($product_ids as $index => $product_id){
            $quantity = $product_quantities[$index];

            $order_product = new OrderProduct;
            $order_product->order_id = $new_order->id;
            $order_product->product_id = $product_id;
            $order_product->ordered_quantity = $quantity;
            $order_product->save();

            Cart::where('product_id', $product_id)->where('user_id', Auth::id())->delete();
        }
        return "success";
    }
}
