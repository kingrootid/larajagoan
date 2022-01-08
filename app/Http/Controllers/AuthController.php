<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            return redirect('/')->withSuccess('Signed in');
        }
        return back()->with('loginError', 'Data email tidak dapat ditemukan');
    }
    public function dummySuperAdmin()
    {
        $validatedData = [
            'name' => 'Super Admin',
            'email' => 'super.admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'Super Admin'
        ];
        User::create($validatedData);
        request()->session()->flash('success', 'Berhasil Mendaftar Akun, Silahkan Login');
        return redirect('/app/login');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/app/login');
    }
}
