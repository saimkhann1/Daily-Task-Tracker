<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
// use League\Config\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    // 1. Response Logic (Jo error dikhana hai)
    $RateLimiterResponse = function (Request $request) {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Too many login attempts. Please try again in 60 seconds.',
            ], 429);
        }
        return back()->withErrors(
       [
            'email' => 'Too many login attempts. Please try again in 60 seconds.',
        ]
    )->withInput($request->except('password'));
    };

    // 2. Rate Limiter Definition
    // Note: Yahan 'use ($RateLimiterResponse)' lagana zaroori hai
    RateLimiter::for('login', function (Request $request) use ($RateLimiterResponse) {
        return [
            // Check by IP
            Limit::perMinute(5)->by($request->ip())->response($RateLimiterResponse),
            
            // Check by Email
            Limit::perMinute(5)->by($request->input('email'))->response($RateLimiterResponse),
        ];
    });
    Password::defaults(function () {
        return Password::min(8)
            ->mixedCase()
            ->letters()
            ->numbers()
            ->symbols()
            ->uncompromised();
    });
    URL::forceScheme('https');
}
}
