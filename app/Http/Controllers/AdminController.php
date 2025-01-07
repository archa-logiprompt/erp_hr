<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function login()
    {
        if (Auth::user()) {
            return view('dashboard');
        }
        return view('dashboard.login.index');
    }

    public function authenticate(Request $request)
    {
      
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return view('dashboard');
        }
        return back();
        }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
