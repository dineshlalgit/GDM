<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\LeaveRequest;

class OwnerLeaveStatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.owner-leave-stats-widget';

    public function getViewData(): array
    {
        $total = LeaveRequest::count();
        $approved = LeaveRequest::where('status', 'approved')->count();
        $pending = LeaveRequest::where('status', 'pending')->count();
        $rejected = LeaveRequest::where('status', 'rejected')->count();
        return [
            'stats' => [
                [
                    'label' => 'Total Leave Requests',
                    'count' => $total,
                    'icon' => 'calendar-days',
                    'desc' => 'All leave requests',
                ],
                [
                    'label' => 'Approved',
                    'count' => $approved,
                    'icon' => 'check-circle',
                    'desc' => 'Approved requests',
                ],
                [
                    'label' => 'Pending',
                    'count' => $pending,
                    'icon' => 'clock',
                    'desc' => 'Pending requests',
                ],
                [
                    'label' => 'Rejected',
                    'count' => $rejected,
                    'icon' => 'x-circle',
                    'desc' => 'Rejected requests',
                ],
            ],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
