<?php

namespace App\Http\Controllers;

use App\Address;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

    public function setting(Request $request){
        $user = $request->user();

        return view('user.setting', compact('user'));
    }

    public function settingPost(Request $request){
        $user = $request->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users,id,'.$user->id,
            'current_password' => 'required',
            'password' => 'required', 'string', 'min:8', 'confirmed',
        ]);


        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('user.setting')->with([
                'status' => false,
                'message' => 'Invalid Current Password!'
            ]);
            // return redirect()->route('user.setting')->with('status', false)->with('message', 'Invalid Current Password!');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        return redirect()->route('user.setting')->with([
            'status' => true,
            'message' => 'Profile Updated!'
        ]);
    }

    public function addreses(Request $request){
        $user = $request->user();

        $addreses = $user->address()->get();

        return view('user.address.list', compact('addreses'));
    }

    public function createAddress(){
        return view('user.address.create');
    }

    public function createAddressPost(Request $request){
        $request->validate([
            'name' => ['required'],
            'house_number' => ['required'],
            'province' => ['required', 'string', 'min:3'],
            'city' => ['required', 'string', 'min:3'],
            'barangay' => ['required', 'string', 'min:3'],
            'mobile_number' => ['required', 'numeric', 'min:10'],
        ]);

        $user = $request->user();

        Address::create([
            'user_id' => $user->id,
            'name' => $request['name'],
            'mobile_number' => $request['mobile_number'],
            'house_number' => $request['housenumber'],
            'province' => $request['province'],
            'city' => $request['city'],
            'barangay' => $request['barangay'],
        ]);


        return redirect()->route('user.addresses')->with([
            'status' => true,
            'message' => 'Address Added!'
        ]);

    }


    //EDIT ADDRESS

    public function editAddress(Request $request, $id){
        $user = $request->user();
        $address = Address::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        return view('user.address.edit', compact('address'));
    }

    public function editAddressPost(Request $request, $id){
        $request->validate([
            'name' => ['required'],
            'house_number' => ['required'],
            'province' => ['required', 'string', 'min:3'],
            'city' => ['required', 'string', 'min:3'],
            'barangay' => ['required', 'string', 'min:3'],
            'mobile_number' => ['required', 'numeric', 'min:10'],
        ]);

        $user = $request->user();

        $address = Address::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $address->name = $request->name;
        $address->house_number = $request->house_number;
        $address->province = $request->province;
        $address->city = $request->city;
        $address->barangay = $request->barangay;
        $address->mobile_number = $request->mobile_number;
        $address->save();

        return redirect()->route('user.addresses.edit', $address->id)->with([
            'status' => true,
            'message' => 'Address Updated!'
        ]);
    }

    public function deleteAddress($id){
        $address = Address::findOrFail($id);

        $address->delete();

        return redirect()->route('user.addresses')->with([
            'status' => true,
            'message' => 'Address Deleted!'
        ]);
    }

    // ORDER HISTORY

    public function orderHistory(Request $request){
        $user = $request->user();

        $orders = $user->orders()->paginate(10);

        return view('user.order.list', compact('orders'));
    }
}
