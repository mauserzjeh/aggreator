<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserType;
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
            switch($user->type->id) {
                case UserType::TYPE_COURIER:
                    // TODO
                    return redirect('/');
                case UserType::TYPE_CUSTOMER:
                    // TODO
                    return redirect('/');
                case UserType::TYPE_MANAGER:
                    // TODO
                    return redirect('/');
            }
        }

        $request->session()->flash('error', 'Invalid credentials');
        return redirect()->route('login');
    }
}