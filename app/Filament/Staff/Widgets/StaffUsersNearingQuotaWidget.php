<?php

namespace App\Filament\Staff\Widgets;

use Filament\Widgets\Concerns\CanSpanColumns;
use Filament\Widgets\Widget;
use App\Models\User;

class StaffUsersNearingQuotaWidget extends Widget
{


    protected static string $view = 'filament.staff.widgets.staff-users-nearing-quota-widget';

    public function getUsersNearingQuota()
    {
        return User::with('role') // Avoid N+1 queries
            ->whereHas('role', fn($q) => $q->where('name', 'user'))
            ->where('quota', '>', 0)
            ->get()
            ->filter(function ($user) {
                return ($user->used_storage / $user->quota) >= 0.8;
            })
            ->sortByDesc(fn($user) => $user->used_storage / $user->quota); // Sort from highest usage
    }


    public function getColumnSpan(): int | string | array
    {
        return 'full'; // 👈 This ensures full width
    }
}
