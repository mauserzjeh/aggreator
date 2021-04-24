<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRestaurantRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'name' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'address' => 'required',
            'restaurant_tags' => [
                'required',
                'array',
                'min:1'
            ],
            'email' => [
                'email',
                'nullable',
                Rule::unique('restaurants')->ignore($this->restaurant_id)
            ]
        ];
    }

    public function attributes() {
        return [
            'restaurant_tags' => 'style'
        ];
    }
}
