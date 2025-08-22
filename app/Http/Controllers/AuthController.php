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
        $req->validate([
            'email' => 'required|email|regex:/@gmail\.com$/',
            'password' => 'required|string|min:6|max:12',
        ]);

        if (Auth::attempt($req->only('email', 'password'))) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|email|regex:/@gmail\.com$/|unique:users,email',
            'password' => 'required|string|min:6|max:12|confirmed',
            'phone' => 'required|regex:/^08[0-9]{8,13}$/',
        ], [
            'email.regex' => 'Email harus menggunakan @gmail.com',
            'phone.regex' => 'Nomor HP harus diawali dengan 08 dan panjang 10-15 digit',
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'phone' => $req->phone,
            'role' => 'user', // otomatis user
        ]);

        Auth::login($user);

        return redirect('/');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
