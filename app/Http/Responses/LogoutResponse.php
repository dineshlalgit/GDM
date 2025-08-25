<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Filament\Http\Responses\Auth\LogoutResponse as BaseLogoutResponse;

class LogoutResponse extends BaseLogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        // Always redirect to the owner login page after logout
        return redirect()->to('/owner/login');
    }
}
