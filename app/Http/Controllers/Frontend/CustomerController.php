<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    
    public function delivery_info() {
        $deliveryinfo = null;

        $user = auth()->user();
        if($user) {
            $deliveryinfo = $user->delivery_information;
        }

        return view('customer.delivery-info', [
            'deliveryinfo' => $deliveryinfo
        ]);
    }

    public function update_delivery_info(Request $request) {
        $input = $request->only([
            'deliveryinfo_id',
            'city',
            'zip_code',
            'address',
            'phone'
        ]);
        
        $user = auth()->user();
        if($input['deliveryinfo_id']) {
            $deliveryinfo = DeliveryInformation::find($input['deliveryinfo_id']);
            if($deliveryinfo && $deliveryinfo->user_id == $user->id) {
                $deliveryinfo->city = $input['city'];
                $deliveryinfo->zip_code = $input['zip_code'];
                $deliveryinfo->address = $input['address'];
                $deliveryinfo->phone = $input['phone'];
                $deliveryinfo->save();

                $request->session()->flash('success', 'Update successful');
                return redirect()->route('deliveryinfo');
            }
        }

        DeliveryInformation::create([
            'user_id' => $user->id,
            'city' => $input['city'],
            'zip_code' => $input['zip_code'],
            'address' => $input['address'],
            'phone' => $input['phone'],
        ]);

        $request->session()->flash('success', 'Update successful');
        return redirect()->route('deliveryinfo');
    }
}