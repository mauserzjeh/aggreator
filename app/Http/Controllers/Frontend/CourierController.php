<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ScheduleHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCourierAvailabilityRequest;
use App\Models\Availability;

class CourierController extends Controller {

    public function availability_index() {
        $user = auth()->user();
        
        $courier_data_availability = ScheduleHelper::DEFAULT_SCHEDULE;
        if ($user) {
            $courier_availability = Availability::where('courier_id', $user->id)->first();
            if($courier_availability) {
                $courier_data_availability = $courier_availability->get_availability();
            }
        }
        
        return view('courier.availability', [
            'courier_id' => $user->id ?? 0,
            'availability' => $courier_data_availability,
            'weekdays' => ScheduleHelper::WEEKDAYS
        ]);
    }

    public function update_availability(UpdateCourierAvailabilityRequest $request) {
        $input = $request->only([
            'courier_id',
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
        if($input['courier_id'] != $user->id) {
            $request->session()->flash('error', 'No permission');
            return redirect()->route('availability');
        }

        $availability = Availability::where('courier_id', $user->id)->first();
        if(!$availability) {
            $availability = new Availability();
        }

        $availability->courier_id = $user->id;
        $availability->set_availability($input);
        $availability->save();

        $request->session()->flash('success', 'Availability information updated');
        return redirect()->route('availability');
    }
}