<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Models\StorageRequest;
use App\Models\LeaveRequest;

class PendingActionsWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.pending-actions-widget';

    public function getPendingStorageRequests()
    {
        return StorageRequest::where('status', 'pending')->with('user')->get();
    }

    public function getPendingLeaveRequests()
    {
        return LeaveRequest::where('status', 'pending')->with('user')->get();
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
