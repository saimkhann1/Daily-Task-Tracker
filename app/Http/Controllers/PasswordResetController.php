<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function showPasswordResetForm()
    {
        return view('auth.forgot-password');
    }
    public function sendPasswordEmail(PasswordResetRequest $request)
    {
        $email =$request->validated()['email'];

        $status = Password::sendResetLink([
            'email' => $email
        ]);
        return back()->with('status', 'if an account exist we will send a password reset link to your email');
    }
    public function showResetPasswordForm(string $token , Request $request)
    {
        return view('auth.reset-password', 
        [
            'token' => $token,
            'email' => $request->string('email')
        ]);
    }
   public function resetPassword(ResetPasswordRequest $request)
{
    $requestData = $request->validated();

    $status = Password::reset($requestData, function($user, string $newPassword) 
    {
        // Galti 1: '$user->newpassword' nahi balki '$user->password' hona chahiye
        // Database mein column ka naam 'password' hota hai.
        $user->password = Hash::make($newPassword);
        
        // Galti 2: Remember Token set karna zaroori hai (Security ke liye)
        $user->setRememberToken(Str::random(60));
        
        $user->save();

        event(new PasswordReset($user));
    });

    if($status === Password::PASSWORD_RESET)
    {
        return redirect()->route('login')->with('status', __($status));
    }

    // Galti 3: ';' (Semicolon) ki jagah brackets ke andar galti thi
    return back()
        ->withInput($request->only('email'))
        ->withErrors(['email' => __($status)]);
}
}
