<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $data =  [
            'title' => env('APP_NAME'),
            'page' => 'Login'
        ];
        return view('app.login', $data);
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request['remember_me'])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }
        return back()->with('loginError', 'Data email tidak dapat ditemukan');
    }
}
