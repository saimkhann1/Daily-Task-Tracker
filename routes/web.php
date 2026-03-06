<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Validation\Rules\Email;
use Illuminate\Validation\Rules\Password;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function(){
    Route::get('/register',[AuthController::class,'ShowRegistrationForm'])->name('register');
    Route::post('/register',[AuthController::class,'register'])->name('register.post');
    Route::get('/login',[AuthController::class,'ShowLoginForm'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login.post');

     Route::post('/email/verification-notification',[EmailVerificationController::class, 'resend'])
    ->middleware('throttle:6,1')->name('verification.send');

    Route::get('/forgot-password',[PasswordResetController::class, 'showPasswordResetForm'])
    ->name('password.request');

      Route::post('/forgot-password',[PasswordResetController::class,'sendPasswordEmail'])
    ->name('password.email');

    Route::get('/reset-password/{token}',[PasswordResetController::class,'showResetPasswordForm'])
    ->name('password.reset'); 

    Route::post('/reset-password',[PasswordResetController::class,'resetPassword'])->name('password.store');
});

Route::middleware('auth')->group(function(){
    Route::get('email/verify',[EmailVerificationController::class, 'index' ])->name('verification.notice');

    Route::get('email/verify/{id}/{hash}',[EmailVerificationController::class,'verify'])->middleware('signed')
    ->name('verification.verify');
    
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});



Route::middleware(['auth','verified'])->group(function(){

    Route::redirect('/','/dashboard');
});