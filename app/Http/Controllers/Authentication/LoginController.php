<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function index() {
        return view('authentication.login');
    }

    /**
     * Log the user in
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) {
        $input = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($input)) {
            return redirect(route('home'));
        }

        $request->session()->flash('error', 'Invalid credentials');
        return redirect()->route('login');
    }

    /** 
     * Log the user out
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}