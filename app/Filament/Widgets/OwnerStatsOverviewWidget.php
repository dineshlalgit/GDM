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

    public function getStats()
    {
        $total = \App\Models\User::count();
        $active = \App\Models\User::where('active', 1)->count();
        $suspended = \App\Models\User::where('active', 0)->count();
        $roles = Role::withCount('users')->get()->map(fn($role) => [
            'role' => $role->name,
            'count' => $role->users_count,
        ]);
        return [
            (object)['value' => $total, 'label' => 'Total Users'],
            (object)['value' => $active, 'label' => 'Active'],
            (object)['value' => $suspended, 'label' => 'Suspended'],
            (object)['value' => $roles, 'label' => 'Role Breakdown'],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
