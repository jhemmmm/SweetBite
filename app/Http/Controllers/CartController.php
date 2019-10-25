<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Cart;
use App\Invoice;
use App\Order;
use App\OrderProduct;
use Auth;

use Srmklive\PayPal\Facades\PayPal;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if(!$user){
            return redirect()->route('login');
        }

        $carts = Cart::with(['product'])->where('user_id', $user->id)->get();

        $categories = Category::get();
        $cart = null;

        if($request->user())
            $cart_count = Cart::where('user_id', Auth::id())->count();


        $addresses = $user->address()->get();

        // dd($addresses);

        $total_price = 0;

        return view('cart', compact('categories', 'carts', 'cart_count', 'total_price', 'addresses'));

        // return view('cart', [
        //     'categories' => $categories,
        //     'carts' => $carts,
        //     'cart_count' => $cart,
        //     'total_price' => $total_price,
        // ]);
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

        $provider = PayPal::setProvider('express_checkout');

        $data = [];

        $product_ids = $request->product_ids;
        $product_quantities = $request->product_quantities;
        $total_price = $request->total_price;

        $new_order = new Order;
        $new_order->user_id = Auth::id();
        $new_order->address_id = $request->address;
        $new_order->paid_price = $total_price;
        $new_order->status = 0; // 0 means not paid // 1 = paid // 2 cancelled
        $new_order->payment_method = $request->payment_method;
        $new_order->save();

        foreach($product_ids as $index => $product_id){
            $quantity = $product_quantities[$index];

            $order_product = new OrderProduct;
            $order_product->order_id = $new_order->id;
            $order_product->product_id = $product_id;
            $order_product->ordered_quantity = $quantity;
            $order_product->save();

            $product = Product::find($product_id);
            $product->quantity = $product->quantity - $quantity;
            $product->save();

            $data['items'][] = [
                'name' => $product->title,
                'price' => $product->price,
                'qty' => $quantity,
                'desc' => $product->description
            ];

            if($request->payment_method == 1){
                Cart::where('product_id', $product_id)->where('user_id', Auth::id())->delete();
            }

        }

        $data['invoice_id'] = $new_order->id;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('order.success', $new_order->id);
        $data['cancel_url'] = url('/cart');

        $total = 0;

        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }

        $data['total'] = $total;

        // //give a discount of 10% of the order amount
        // $data['shipping_discount'] = round((10 / 100) * $total, 2);

        $invoice = new Invoice;
        $invoice->order_id = $new_order->id;
        $invoice->save();

        if($request->payment_method == 2){
            $response = $provider->setExpressCheckout($data);

            $invoice->transaction_token = $response['TOKEN'];
            $invoice->save();

            return response()->json([
                'redirect_url' => $response['paypal_link'],
            ]);

        }else{
            return response()->json([
                'redirect_url' => route('order.success', $new_order->id)
            ]);
        }
    }

    public function orderSuccess(Request $request, $id){

        $invoice = Invoice::where('transaction_token', $request->token)->firstOrFail();

        $provider = PayPal::setProvider('express_checkout');
        $response = $provider->getExpressCheckoutDetails($request->token);

        $order = Order::with(['products'])->findOrFail($invoice->order_id);
        if($response['BILLINGAGREEMENTACCEPTEDSTATUS'] != 1){
            $order->status = 5;
            foreach($order->products as $product){
                $prod = Product::where('id', $product->product_id)->first();

                $prod->quantity = $prod->quantity + $product->ordered_quantity;
                $prod->save();
            }
            $order->save();

            $message = 'Your Order has been cancelled';
        }


        if($order->status == 0){
            $order->status = 3;
            $order->save();
        }else{
            abort(401);
        }

        $message = 'Your Order has been successfully placed';

        return view('success', compact('message'));
    }
}
