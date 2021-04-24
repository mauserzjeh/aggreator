<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller {

    /**
     * Index
     * 
     * @return \Illuminate\View\View
     */
    public function index() {
        $user = auth()->user();
        return view('profile.index', [
            'user' => $user
        ]);
    }

    /**
     * Update user data
     * 
     * @param \App\Http\Requests\UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request) {
        $input = $request->only([
            'user_id',
            'name',
            'email',
            'password',
        ]);
        
        $user  = auth()->user();
        if($user && $user->id == $input['user_id']) {
            $user->name = $input['name'];
            $user->email = $input['email'];

            if($input['password']) {
                $user->password = $input['password'];
            }

            $user->save();
            $request->session()->flash('success', 'Profile update succesful');
            return redirect()->route('profile');
        }

        $request->session()->flash('error', 'Error updating profile');
        return redirect()->route('profile');
    }
}