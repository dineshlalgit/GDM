<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\MediaFile;

class StorageUsageOverviewWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.storage-usage-overview-widget';

    public function getStats()
    {
        $userIds = User::pluck('id');
        $totalFiles = MediaFile::whereIn('user_id', $userIds)->count();
        $totalStorage = 0;
        foreach ($userIds as $id) {
            $user = User::find($id);
            $totalStorage += $user?->used_storage ?? 0;
        }
        $avgStorage = $userIds->count() ? $totalStorage / $userIds->count() : 0;
        return [
            (object)['value' => round($totalStorage / (1024*1024*1024), 2) . ' GB', 'label' => 'Total Storage Used'],
            (object)['value' => $totalFiles, 'label' => 'Total Files'],
            (object)['value' => round($avgStorage / (1024*1024*1024), 2) . ' GB', 'label' => 'Avg Storage/User'],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
