<?php

namespace App\Filament\Staff\Widgets;

use Filament\Widgets\Widget;
use App\Models\MediaFile;
use App\Models\User;

class StaffRecentUploadsWidget extends Widget
{
    protected static string $view = 'filament.staff.widgets.staff-recent-uploads-widget';

    public function getRecentUploads()
    {
        $userIds = User::whereHas('role', fn($q) => $q->where('name', 'user'))->pluck('id');
        return MediaFile::whereIn('user_id', $userIds)->latest('uploaded_at')->take(5)->get();
    }
}
