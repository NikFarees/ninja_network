<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($validated);

        Auth::login($user); // Automatically log in the user after registration

        return redirect()->route('ninjas.index');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if( Auth::attempt($validated)) {
            $request->session()->regenerate(); // Regenerate session to prevent session fixation attacks

            return redirect()->route('ninjas.index');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Sorry, incorrect credentials.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user

        // good practice: clear the session
        $request->session()->invalidate(); // remove other data in the session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect()->route('show.login');


    }
}
