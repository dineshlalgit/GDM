<?php

namespace App\Filament\Staff\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;

class StaffTopUsersByStorageWidget extends Widget
{
    protected static string $view = 'filament.staff.widgets.staff-top-users-by-storage-widget';

    public function getTopUsers()
    {
        return User::whereHas('role', fn($q) => $q->where('name', 'user'))
            ->with('mediaFiles')
            ->get()
            ->sortByDesc(fn($user) => $user->used_storage)
            ->take(5);
    }
}
