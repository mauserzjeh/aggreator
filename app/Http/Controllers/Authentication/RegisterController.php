<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller {

    /**
     * Index
     * 
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('authentication.register');
    }

    /**
     * Register a new user
     * 
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request) {
        $input = $request->only([
            'name',
            'email',
            'register_as',
            'password'
        ]);
        
        User::create([
            'name' => trim($input['name']),
            'email' => $input['email'],
            'user_type_id' => $input['register_as'],
            'password' => $input['password']
        ]);

        $request->session()->flash('success', 'Registration is successful.');
        return redirect()->route('login');
    }
}