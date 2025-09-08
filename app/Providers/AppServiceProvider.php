<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use Illuminate\Support\Facades\Schedule;

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

        // Event status is computed now; no scheduler required.
    }

    public $singletons = [
        \Filament\Http\Responses\Auth\Contracts\LogoutResponse::class => \App\Http\Responses\LogoutResponse::class,
    ];

    // Removed scheduler that used to persist event status
}
