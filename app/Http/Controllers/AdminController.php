<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Invoice;
use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nexmo\Laravel\Facade\Nexmo;
use Image;

class AdminController extends Controller{


    public function index(){

        $orders = Order::orderBy('created_at', 'DESC')->whereIn('status', [3])->whereDate('created_at', Carbon::now()->toDateString())->paginate(10);

        $shipped = Order::where('status', 2)->count();

        $dailyEarnings = Order::whereDate('created_at', Carbon::now()->toDateString())->select(DB::raw('sum(paid_price) as total_amount'))->first();
;

        $pendingPayments = Order::whereDate('created_at', Carbon::now()->toDateString())->where('status', 0)->count();

        $cancelled = Invoice::whereDate('created_at', Carbon::now()->toDateString())->where('status', 3)->count();

        $refunded = Invoice::whereDate('created_at', Carbon::now()->toDateString())->where('status', 2)->count();


        return view('admin.index', compact('orders', 'shipped', 'dailyEarnings', 'pendingPayments', 'cancelled', 'refunded'));
    }


    public function userLists(){
        $users = User::paginate(15);

        return view('admin.user.list', compact('users'));
    }

    public function userUpdate($id){
        $user = User::findOrFail($id)->first();

        return view('admin.user.update', compact('user'));
    }

    public function userPostUpdate(Request $request, $id){

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users,id,'.$user->id,
            'password' => 'nullable', 'min:8'
        ]);

        $user->update($request->except(['password', '_token']));

        if($request->password){
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('admin.user.update', $user->id)->with([
            'status' => true,
            'message' => 'User Updated!'
        ]);
    }

    public function userDelete($id){

        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.user.list')->with([
            'status' => true,
            'message' => 'User Deleted!'
        ]);

    }

    // Product Functions

    public function productList(){
        $products = Product::orderBy('id', 'DESC')->paginate(20);

        return view('admin.product.list', compact('products'));
    }

    public function productUpdate($id){
        $product = Product::findOrFail($id);

        $categories = Category::get();

        return view('admin.product.update', compact('product', 'categories'));
    }

    public function productUpdatePost(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image' => 'file',
            'description' => 'required',
        ]);

        $product = Product::where('id', $id)->first();

        $product->update($request->except(['_token', 'image']));

        if($request->has('image')){
            $image = Image::make($request->image->getRealPath())->resize(300, 300)->save(public_path('images/products/'.$id . '_'. md5(time()) .'.jpg'));

            $product->image = '/images/products/'.$id . '_'. md5(time()) .'.jpg';
            $product->save();
        }

        return redirect()->route('admin.product.update', $id)->with([
            'status' => true,
            'message' => 'Product Updated!'
        ]);
    }

    public function productCreate(){
        $categories = Category::get();

        return view('admin.product.create', compact('categories'));
    }

    public function productStore(Request $request){
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image' => 'required|file',
            'description' => 'required',
        ]);

        $product = Product::create($request->except(['_token', 'image']));

        $image = Image::make($request->image->getRealPath())->resize(300, 300)->save(public_path('images/products/'.$product->id . '_'. md5(time()) .'.jpg'));

        $product->image = '/images/products/'.$product->id . '_'. md5(time()) .'.jpg';
        $product->save();

        return redirect()->route('admin.product.list')->with([
            'status' => true,
            'message' => 'Product Added!'
        ]);

    }

    public function productDelete($id){
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.product.list')->with([
            'status' => true,
            'message' => 'Product Deleted!'
        ]);
    }

    // order list function

    public function orderLists(){
        $orders = Order::latest()->paginate(20);

        return view('admin.order.list', compact('orders'));
    }

    public function orderView($id){
        $order = Order::findOrFail($id);

        return view('admin.order.view', compact('order'));
    }

    public function orderUpdateStatus(Request $request, $id){
        $order = Order::with('invoice')->findOrFail($id);

        $number = $order->address->mobile_number;

        $number = substr($number, 1);

        $number = '63'. $number;

        if($request->status == 'shipped'){
            $order->status = 2;
            Nexmo::message()->send([
                'to'   => $number,
                'from' => '639217421936',
                'text' => 'Order # '.$order->id.' has been shipped'
            ]);
        }else{
            $order->status = 1;
            Nexmo::message()->send([
                'to'   => $number,
                'from' => '639217421936',
                'text' => 'Order # '.$order->id.' is succesfully delivered'
            ]);
        }

        $order->save();

        return redirect()->route('admin.order.view', $id)->with([
            'status' => true,
            'message' => 'Succesfully updated'
        ]);

    }

    public function invoiceList(){

    }

    public function invoiceView($id){
        $invoice = Invoice::with([
            'order' => function($q){
                $q->with(['address', 'user']);
            }
        ])->findOrFail($id);

        // dd($invoice);

        return view('admin.invoice.view', compact('invoice'));
    }
}
