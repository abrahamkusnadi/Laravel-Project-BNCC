<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $req)
    {
        $credentials = $req->validate([
            'email' => 'required|email|regex:/@gmail\.com$/',
            'password' => 'required|string|min:6|max:12',
        ]);

        if (auth()->attempt($credentials)) {
            $req->session()->regenerate();
            
            if(auth()->user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }

            return redirect()->route('user.dashboard')->with('success', 'Login successful!');
        }
    

        return back()->withErrors([
            'email' => 'These credentials do not match our records',
        ])->onlyInput('email');
    }

    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|email|regex:/@gmail\.com$/|unique:users,email',
            'password' => 'required|string|min:6|max:12|confirmed',
            'phone' => 'required|regex:/^08[0-9]{8,13}$/',
        ], [
            'email.regex' => 'Email must end with @gmail.com.',
            'phone.regex' => 'Phone must start with "08" (10-15 digits).',
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'phone' => $req->phone,
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Successfully registered! Please login with your credentials.');
    }


public function logout(Request $request)
    {
        Auth::logout();
        
        // Deleting session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been successfully logged out.');
    }
}
