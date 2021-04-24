<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourierAvailabilityRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'courier_id' => [
                'required'
            ],
            'mon_b' => [
                'required',
            ],
            'mon_e' => [
                'required',
            ],
            'tue_b' => [
                'required',
            ],
            'tue_e' => [
                'required',
            ],
            'wed_b' => [
                'required',
            ],
            'wed_e' => [
                'required',
            ],
            'thu_b' => [
                'required',
            ],
            'thu_e' => [
                'required',
            ],
            'fri_b' => [
                'required',
            ],
            'fri_e' => [
                'required',
            ],
            'sat_b' => [
                'required',
            ],
            'sat_e' => [
                'required',
            ],
            'sun_b' => [
                'required',
            ],
            'sun_e' => [
                'required',
            ],
        ];
    }
}