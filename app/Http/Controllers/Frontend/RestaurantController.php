<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;
use App\Models\RestaurantTag;

class RestaurantController extends Controller {

    public function index() {
        $restaurant_data = null;
        $restaurant_data_tags = [];

        $user = auth()->user();
        if($user) {
            $restaurant_data = Restaurant::where('user_id', $user->id)->first();
            $restaurant_data_tags = $restaurant_data->tags->pluck('id')->toArray();
        }
        // dd($restaurant_data_tags);
        $restaurant_tags = RestaurantTag::all();
        return view('restaurant.index', [
            'restaurant_data' => $restaurant_data,
            'restaurant_tags' => $restaurant_tags,
            'restaurant_data_tags' => $restaurant_data_tags
        ]);
    }

    public function update(UpdateRestaurantRequest $request) {
        $input = $request->only([
            'restaurant_id',
            'name',
            'zip_code',
            'city',
            'address',
            'restaurant_tags',
            'email',
            'phone',
            'mobile_phone',
            'description'
        ]);

        $user = auth()->user();
        if($input['restaurant_id']) {
            $restaurant = Restaurant::find($input['restaurant_id']);
            if($restaurant && $restaurant->user_id == $user->id) {
                $restaurant->name = $input['name'];
                $restaurant->zip_code = $input['zip_code'];
                $restaurant->city = $input['city'];
                $restaurant->address = $input['address'];
                $restaurant->email = $input['email'];
                $restaurant->phone = $input['phone'];
                $restaurant->mobile_phone = $input['mobile_phone'];
                $restaurant->description = $input['description'];

                $restaurant->tags()->sync($input['restaurant_tags']);

                $request->session()->flash('success', 'Update successful');
                return redirect()->route('restaurant.details');
            }

        }


        $restaurant = Restaurant::create([
            'user_id' => $user->id,
            'name' => $input['name'],
            'zip_code' => $input['zip_code'],
            'city' => $input['city'],
            'address' => $input['address'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'mobile_phone' => $input['mobile_phone'],
            'description' => $input['description']
        ]);

        $restaurant->tags()->sync($input['restaurant_tags']);

        $request->session()->flash('success', 'Update successful');
        return redirect()->route('restaurant.details');
    }
}