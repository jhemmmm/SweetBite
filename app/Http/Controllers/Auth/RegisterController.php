<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Address;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $provinces = resource_path('json/provinces.json');

        $provinces = json_decode(file_get_contents($provinces), true);
        // $provinces = collect($provinces);

        // $cities = resource_path('json/cities.json');
        // $cities = json_decode(file_get_contents($cities), true);


        // foreach($provinces as $key => $province){
        //     foreach($cities as $city){
        //         if($province['key'] == $city['province']){
        //             if(!isset($provinces[$key]['cities'])){
        //                 $provinces[$key]['cities'] = [];
        //                 array_push($provinces[$key]['cities'], $city);
        //             }else{
        //                 array_push($provinces[$key]['cities'], $city);
        //             }
        //         }
        //     }
        // }

        // $provinces = collect($provinces)->toJson();

        // dd($provinces);

        return view('auth.register', compact('provinces'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'housenumber' => ['required'],
            'province' => ['required', 'string', 'min:3'],
            'city' => ['required', 'string', 'min:3'],
            'barangay' => ['required', 'string', 'min:3'],
            'mobile' => ['required', 'numeric', 'min:11', 'regex:/^(09|\+639)\d{9}$/'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Address::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'mobile_number' => $data['mobile'],
            'house_number' => $data['housenumber'],
            'province' => $data['province'],
            'city' => $data['city'],
            'barangay' => $data['barangay'],
        ]);

        return $user;
    }
}
