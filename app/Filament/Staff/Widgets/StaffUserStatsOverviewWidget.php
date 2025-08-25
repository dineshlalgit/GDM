<?php

namespace App\Filament\Staff\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;

class StaffUserStatsOverviewWidget extends Widget
{
    protected static string $view = 'filament.staff.widgets.staff-user-stats-overview-widget';

    public function getStats()
    {
        $total = User::whereHas('role', fn($q) => $q->where('name', 'user'))->count();
        $active = User::whereHas('role', fn($q) => $q->where('name', 'user'))->where('active', 1)->count();
        $suspended = User::whereHas('role', fn($q) => $q->where('name', 'user'))->where('active', 0)->count();
        return [
            (object)['value' => $total],
            (object)['value' => $active],
            (object)['value' => $suspended],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
