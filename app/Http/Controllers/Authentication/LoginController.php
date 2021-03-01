<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function index() {
        return view('authentication.login');
    }

    public function login(Request $request) {
        $input = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($input)) {
            $user = User::where('email', $input['email'])->first();
            switch($user->type) {
                case User::TYPE_COURIER:
                    return redirect()->route('courier.home');
                case User::TYPE_CUSTOMER:
                    return redirect()->route('customer.home');
                case User::TYPE_MANAGER:
                    return redirect()->route('manager.home');
            }
        }

        $request->session()->flash('error', 'Invalid credentials');
        return redirect()->route('login');
    }
}