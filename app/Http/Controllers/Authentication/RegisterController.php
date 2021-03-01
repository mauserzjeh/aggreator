<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller {

    public function index() {
        return view('authentication.register');
    }

    public function register(RegisterRequest $request) {
        $input = $request->only([
            'name',
            'email',
            'type',
            'password'
        ]);
        
        User::create([
            'name' => trim($input['name']),
            'email' => $input['email'],
            'type' => $input['type'],
            'password' => $input['password']
        ]);

        $request->session()->flash('success', 'Registration is successful.');
        return redirect()->route('login');
    }
}