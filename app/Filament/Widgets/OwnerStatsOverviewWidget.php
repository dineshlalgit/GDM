<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\Role;

class OwnerStatsOverviewWidget extends Widget
{
    protected static string $view = 'filament.widgets.owner-stats-overview-widget';

    public function getViewData(): array
    {
        $roles = ['Owner', 'Admin', 'Staff', 'User'];
        $roleCounts = [];
        foreach ($roles as $roleName) {
            $roleCounts[$roleName] = User::whereHas('role', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            })->count();
        }
        $total = array_sum($roleCounts);
        return [
            'total' => $total,
            'roleCounts' => $roleCounts,
        ];
    }



    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
