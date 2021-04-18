<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\DeliveryInformation;
use App\Models\Restaurant;
use App\Models\RestaurantSchedule;
use App\Models\User;
use App\Models\UserType;

class RegisterController extends Controller {

    /**
     * Index
     * 
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('authentication.register');
    }

    /**
     * Register a new user
     * 
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request) {
        $input = $request->only([
            'name',
            'email',
            'register_as',
            'password'
        ]);
        
        $user = User::create([
            'name' => trim($input['name']),
            'email' => $input['email'],
            'user_type_id' => $input['register_as'],
            'password' => $input['password']
        ]);

        //If manager registered, then setup a some default stuff
        if($input['register_as'] == UserType::TYPE_MANAGER) {
            $restaurant = Restaurant::create([
                'user_id' => $user->id,
                'name' => '',
                'zip_code' => '',
                'city' => '',
                'address' => '',
                'email' => null,
                'phone' => null,
                'mobile_phone' => null,
                'description' => null
            ]);

            $restaurant_schedule = new RestaurantSchedule();
            $restaurant_schedule->restaurant_id = $restaurant->id;
            $restaurant_schedule->set_default_schedule();
            $restaurant_schedule->save();
        }

        //If customer registered, then setup some default stuff
        if($input['register_as'] == UserType::TYPE_CUSTOMER) {
            DeliveryInformation::create([
                'user_id' => $user->id,
                'city' => '',
                'zip_code' => '',
                'address' => '',
                'phone' => ''
            ]);
        }

        $request->session()->flash('success', 'Registration is successful.');
        return redirect()->route('login');
    }
}