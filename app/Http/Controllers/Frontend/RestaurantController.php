<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ScheduleHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Requests\UpdateRestaurantScheduleRequest;
use App\Models\Restaurant;
use App\Models\RestaurantSchedule;
use App\Models\RestaurantTag;

class RestaurantController extends Controller {

    public function index() {
        $restaurant_data = null;
        $restaurant_data_tags = [];
        $restaurant_data_schedule = ScheduleHelper::DEFAULT_SCHEDULE;

        $user = auth()->user();
        if($user) {
            $restaurant_data = Restaurant::where('user_id', $user->id)->first();
            $restaurant_data_tags = $restaurant_data->tags->pluck('id')->toArray();
            $restaurant_schedule = RestaurantSchedule::where('restaurant_id', $restaurant_data->id)->first();
            if($restaurant_schedule) {
                $restaurant_data_schedule = $restaurant_schedule->get_schedule();
            }
        }

        $restaurant_tags = RestaurantTag::all();
        return view('restaurant.index', [
            'restaurant_data' => $restaurant_data,
            'restaurant_tags' => $restaurant_tags,
            'restaurant_data_tags' => $restaurant_data_tags,
            'restaurant_data_schedule' => $restaurant_data_schedule,
            'weekdays' => ScheduleHelper::WEEKDAYS
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

    public function update_schedule(UpdateRestaurantScheduleRequest $request) {
        $input = $request->only([
            'restaurant_id',
            'mon_b',
            'mon_e',
            'tue_b',
            'tue_e',
            'wed_b',
            'wed_e',
            'thu_b',
            'thu_e',
            'fri_b',
            'fri_e',
            'sat_b',
            'sat_e',
            'sun_b',
            'sun_e',
        ]);

        $user = auth()->user();
        if(!$input['restaurant_id']) {
            $request->session()->flash('error', 'Please fill in the restaurant details before setting the schedule.');
            return redirect()->route('restaurant.details');
        }

        $restaurant_schedule = RestaurantSchedule::where('restaurant_id', $input['restaurant_id'])->first();
        if(!$restaurant_schedule) {
            $restaurant_schedule = new RestaurantSchedule();
        }

        $restaurant_schedule->restaurant_id = $input['restaurant_id'];
        $restaurant_schedule->set_schedule($input);
        $restaurant_schedule->save();

        $request->session()->flash('success', 'Schedule information updated');
        return redirect()->route('restaurant.details');
    }
}