<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required', 
                'email', 
                'unique:\App\Models\User'
            ],
            'type' => [
                'required',
                Rule::in(\App\Models\User::TYPES)
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ]
        ];
    }

    /**
     * Get the validation messages
     * 
     * @return array
     */
    public function messages() {
        return [
            'password.regex' => 'The password must contain at least one number and both uppercase and lowercase letters.'
        ];
    }
}
