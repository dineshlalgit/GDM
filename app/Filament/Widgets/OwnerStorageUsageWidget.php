<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Storage;

class OwnerStorageUsageWidget extends Widget
{
    protected static string $view = 'filament.widgets.owner-storage-usage-widget';

    public function getViewData(): array
    {
        // Path to the media storage directory
        $mediaPath = storage_path('app/public/media');

        // Calculate used space (sum of all files in mediaPath)
        $used = 0;
        if (is_dir($mediaPath)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($mediaPath, \FilesystemIterator::SKIP_DOTS)) as $file) {
                if ($file->isFile()) {
                    $used += $file->getSize();
                }
            }
        }

        // Get total and free space on the partition
        $total = disk_total_space($mediaPath);
        $free = disk_free_space($mediaPath);

        // Format for display
        $usedGB = number_format($used / (1024 * 1024 * 1024), 2) . ' GB';
        $totalGB = number_format($total / (1024 * 1024 * 1024), 1) . ' GB';
        $freeGB = number_format($free / (1024 * 1024 * 1024), 1) . ' GB';
        $percent = $total > 0 ? round(($used / $total) * 100, 1) : 0;

        return [
            'total' => $totalGB,
            'used' => $usedGB,
            'free' => $freeGB,
            'percent' => $percent,
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
