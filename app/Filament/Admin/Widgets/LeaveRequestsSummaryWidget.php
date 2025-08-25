<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestsSummaryWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.leave-requests-summary-widget';

    public function getStats()
    {
        $userId = Auth::id();
        $pending = \App\Models\LeaveRequest::where('user_id', $userId)->where('status', 'pending')->count();
        $approved = \App\Models\LeaveRequest::where('user_id', $userId)->where('status', 'approved')->count();
        $rejected = \App\Models\LeaveRequest::where('user_id', $userId)->where('status', 'rejected')->count();
        return [
            (object)['value' => $pending, 'label' => 'Pending'],
            (object)['value' => $approved, 'label' => 'Approved'],
            (object)['value' => $rejected, 'label' => 'Rejected'],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
