<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Models\StorageRequest;
use App\Models\User;

class RecentStorageRequestsWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.recent-storage-requests-widget';

    public function getRecentRequests()
    {
        return StorageRequest::with('user.role')->latest('created_at')->take(5)->get();
    }
}
