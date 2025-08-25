<?php

namespace App\Filament\Staff\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\MediaFile;

class StaffStorageUsageWidget extends Widget
{
    protected static string $view = 'filament.staff.widgets.staff-storage-usage-widget';

    public function getStats()
    {
        $userIds = User::whereHas('role', fn($q) => $q->where('name', 'user'))->pluck('id');
        $totalFiles = MediaFile::whereIn('user_id', $userIds)->count();
        $totalStorage = 0;
        foreach ($userIds as $id) {
            $user = User::find($id);
            $totalStorage += $user?->used_storage ?? 0;
        }
        $avgStorage = $userIds->count() ? $totalStorage / $userIds->count() : 0;
        return [
            (object)['value' => round($totalStorage / (1024*1024*1024), 2) . ' GB'],
            (object)['value' => $totalFiles],
            (object)['value' => round($avgStorage / (1024*1024*1024), 2) . ' GB'],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
