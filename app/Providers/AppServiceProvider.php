<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

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
        // Set default timezone
        date_default_timezone_set(config('app.timezone', 'Asia/Kolkata'));
        // Redirect /login to /owner/login
        Route::redirect('/login', '/owner/login');
    }

    public $singletons = [
        \Filament\Http\Responses\Auth\Contracts\LogoutResponse::class => \App\Http\Responses\LogoutResponse::class,
    ];
}
