<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function ShowRegistrationForm()
    {
        return view('auth.register');
    }
    public function ShowLoginForm()
    {
        return view('auth.login');
    }
    public function login(AuthRequest $request)
    {
       if(Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))){
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
       }
       return back()->withInput()->withErrors([
        'email' => 'The provided credentials do not match our records.',
       ]);
    }
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([  
            'name' => $validated['name'],
            'email' =>$validated['email'],
            'password' =>Hash::make($validated['password']),
        ]);
        event(new Registered($user));
        Auth::login($user);
        return redirect()->intended(route('dashboard',absolute:false));
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
