<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\Role;

class UserStatsOverviewWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.user-stats-overview-widget';

    public function getStats()
    {
        $rolesToShow = ['staff', 'user'];
        $total = User::whereHas('role', fn($q) => $q->whereIn('name', $rolesToShow))->count();
        $active = User::whereHas('role', fn($q) => $q->whereIn('name', $rolesToShow))->where('active', 1)->count();
        $suspended = User::whereHas('role', fn($q) => $q->whereIn('name', $rolesToShow))->where('active', 0)->count();
        $roles = Role::whereIn('name', $rolesToShow)
            ->withCount(['users' => function($q) { $q->whereIn('role_id', Role::whereIn('name', ["staff", "user"])->pluck('id')); }])
            ->get()
            ->map(fn($role) => [
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
