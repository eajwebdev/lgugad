<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (! auth()->attempt($credentials, $request->boolean('remember'))) {
            return redirect()->back()->withInput($request->only('username'))->with('error', 'Invalid Credentials');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Login Successfully');
    }
}
