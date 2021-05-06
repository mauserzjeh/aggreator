<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FinalizeOrderRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'city' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'order_items' => [
                'required',
                'array',
                'min:1'
            ],
            'order_quantities' => [
                'required',
                'array',
                'min:1'
            ],
            'delivery_type' => [
                'required',
                Rule::in(array_keys(Order::DELIVERY_TYPES))
            ]
        ];
    }
}