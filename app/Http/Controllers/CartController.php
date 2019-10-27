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
use Illuminate\Support\Facades\DB;
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

        foreach($request->product_ids as $index => $product_id){
            $quantity = $request->product_quantities[$index];

            $product = Product::find($product_id);
            if($product->quantity < $quantity){
                return response()->json([
                    'status' => false,
                    'message' => $product->title. ' is out of stock'
                ]);
            }
        }

        DB::beginTransaction();

        try{
            $provider = PayPal::setProvider('express_checkout');

            $data = [];

            $product_ids = $request->product_ids;
            $product_quantities = $request->product_quantities;
            $total_price = $request->total_price; //SF

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
            $data['items'][] = [
                'name' => 'Shipping Fee',
                'price' => 100,
                'qty' => 1,
                'desc' => 'Order Shipping Fee'
            ];

            $data['invoice_id'] = $new_order->id;
            $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
            $data['return_url'] = route('order.success', $new_order->id);
            $data['cancel_url'] = url('/cart');

            $total = 0;

            foreach($data['items'] as $item) {
                $total += $item['price']*$item['qty'];
            }

            $data['total'] = $total;

            $invoice = new Invoice;
            $invoice->order_id = $new_order->id;
            $invoice->status = 0; // 0 = not process, 1 = process
            $invoice->save();

            if($request->payment_method == 2){
                $response = $provider->setExpressCheckout($data);

                $invoice->transaction_token = $response['TOKEN'];
                $invoice->save();

                DB::commit();
                return response()->json([
                    'status' => true,
                    'redirect_url' => $response['paypal_link'],
                ]);

            }else{
                DB::commit();
                return response()->json([
                    'status' => true,
                    'redirect_url' => route('order.success', $new_order->id)
                ]);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Might have some internet connection problem try again. Reloading...'
            ]);
        }
    }

    public function orderSuccess(Request $request, $id){

        if($request->token && $request->PayerID){

            $invoice = Invoice::where('transaction_token', $request->token)->firstOrFail();

            $order = Order::with(['products'])->findOrFail($invoice->order_id);

            foreach($order->products as $product){
                $data['items'][] = [
                    'name' => $product->title,
                    'price' => $product->price,
                    'qty' => $product->pivot->ordered_quantity,
                    'desc' => $product->description
                ];
            }
            $data['items'][] = [
                'name' => 'Shipping Fee',
                'price' => 100,
                'qty' => 1,
                'desc' => 'Order Shipping Fee'
            ];
            $data['invoice_id'] = $invoice->id;
            $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
            $data['return_url'] = route('order.success', $order->id);
            $data['cancel_url'] = url('/cart');

            $total = 0;

            foreach($data['items'] as $item) {
                $total += $item['price']*$item['qty'];
            }

            $data['total'] = $total;

            $provider = PayPal::setProvider('express_checkout');

            $response = $provider->doExpressCheckoutPayment($data, $request->token, $request->PayerID);

            if($response['PAYMENTINFO_0_PAYMENTSTATUS'] != 'Completed'){
                $order->status = 5;
                foreach($order->products as $product){
                    $prod = Product::where('id', $product->id)->first();

                    $prod->quantity = $prod->quantity + $product->ordered_quantity;
                    $prod->save();
                }
                $order->save();

                $message = 'Your Order has been cancelled';
            }else{
                Cart::where('user_id', Auth::id())->delete();
                $invoice->transaction_id = $response['PAYMENTINFO_0_TRANSACTIONID'];
                $invoice->status = 1;
                $invoice->save();
                if($order->status == 0){
                    $order->status = 3;
                    $order->save();
                }else{
                    abort(401);
                }

                $message = 'Your Order has been successfully placed';
            }
        }else{

            $order = Order::where('id', $id)->first();
            $order->status = 3;
            $order->save();

            $invoice = $order->invoice;
            $invoice->transaction_id = md5(time());
            $invoice->status = 1;
            $invoice->save();

            $message = 'Your Order has been successfully placed';


        }

        return view('success', compact('message', 'order'));
    }

    public function cartDelete($id){
        $cart = Cart::where('id', $id)->firstOrFail();
        $cart->delete();

        return redirect()->route('cart');
    }
}
