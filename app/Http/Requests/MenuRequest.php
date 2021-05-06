<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => [
                'required',
            ],
            'price' => [
                'required',
                'numeric',
                'gt:0'
            ],
            'category' => [
                'required'
            ]
        ];
    }
}