<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCheckoutRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'order_items' => [
                'required',
                'array',
                'min:1'
            ]
        ];
    }

    public function messages() {
        return [
            'order_items.required' => 'You must have at least one item selected to be able to order.'
        ];
    }
}