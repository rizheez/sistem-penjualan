<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            // Login berhasil
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        } else {
            // Login gagal
            return redirect()->back()->withErrors(['login' => 'Username atau password salah']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
