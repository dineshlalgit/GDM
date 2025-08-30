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

        // Schedule automatic event status updates
        $this->scheduleEventStatusUpdates();
    }

    public $singletons = [
        \Filament\Http\Responses\Auth\Contracts\LogoutResponse::class => \App\Http\Responses\LogoutResponse::class,
    ];

    /**
     * Schedule automatic event status updates.
     */
    private function scheduleEventStatusUpdates(): void
    {
        // Run every minute to check for events that need to be closed
        Schedule::call(function () {
            Event::closePastEvents();
        })->everyMinute();
    }
}
