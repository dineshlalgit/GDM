<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\MediaFile;

class StorageUsageWidget extends Widget
{
    protected static string $view = 'filament.widgets.storage-usage-widget';

    public static function canView(): bool
    {
        return true;
    }

    // protected static ?int $sort = 0;

    protected string|int|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user = Auth::user();
        $defaultQuota = 5 * 1024 * 1024 * 1024; // 5 GB in bytes
        $total = $user && isset($user->quota) ? (int) $user->quota : $defaultQuota;
        $used = 0;
        if ($user) {
            $files = MediaFile::where('user_id', $user->id)->get();
            foreach ($files as $file) {
                $used += Storage::disk('public')->exists($file->file_path)
                    ? Storage::disk('public')->size($file->file_path)
                    : 0;
            }
        }
        // Convert bytes to GB for display
        $usedGB = number_format($used / (1024 * 1024 * 1024), 2) . ' GB';
        $totalGB = number_format($total / (1024 * 1024 * 1024), 1) . ' GB';
        $percent = $total > 0 ? round(($used / $total) * 100, 1) : 0;

        return [
            'total' => $totalGB,
            'used' => $usedGB,
            'percent' => $percent,
        ];
    }
}
