<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('dashbord'));
        };

        return back()->withErrors(['email'=> 'Invalid credentials.'])->onlyInput('email');
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }
}
