<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profileRead()
    {
        return view('profile.info', ['user' => Auth::user()]);
    }

    public function profileUpdate(Request $request)
    {
        // Role and module access are managed by administrators in User Management, not here.
        $validated = $request->validate([
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mname' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore(Auth::id())],
            'gender' => 'required|string|max:10',
        ]);

        Auth::user()->update($validated);

        return redirect()->route('profileRead')->with('success', 'Profile updated successfully');
    }

    public function profilePassUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:5',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('profileRead')->with('success', 'Password updated successfully');
    }
}
