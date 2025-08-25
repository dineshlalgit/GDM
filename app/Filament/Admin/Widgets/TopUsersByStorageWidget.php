<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;

class TopUsersByStorageWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.top-users-by-storage-widget';

    public function getTopUsers()
    {
        return User::with('mediaFiles', 'role')
            ->get()
            ->sortByDesc(fn($user) => $user->used_storage)
            ->take(5);
    }
}
