<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuCategoryRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => [
                'required',
                Rule::unique('menu_categories')->ignore($this->category_id)
            ]
        ];
    }
}