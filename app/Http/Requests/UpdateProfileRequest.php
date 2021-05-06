<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'user_id' => 'required',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user_id)
            ],
            'old_password' => [
                'nullable',
                'password',
                'required_with:password'
            ],
            'password' => [
                'nullable',
                'required_with:old_password',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/'
            ],
            'password_confirmation' => [
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
