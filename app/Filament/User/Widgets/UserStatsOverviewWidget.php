<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\MediaFile;
use Illuminate\Support\Facades\Auth;

class UserStatsOverviewWidget extends StatsOverviewWidget
{
    protected static string $view = 'filament.widgets.user-stats-overview-widget';

    protected function getViewData(): array
    {
        $userId = Auth::id();
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $videoTypes = ['mp4', 'mov', 'avi'];
        $audioTypes = ['mp3', 'wav', 'ogg'];
        $docTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
        $excludedTypes = array_merge($imageTypes, $videoTypes, $audioTypes, $docTypes);

        return [
            'stats' => [
                [
                    'label' => 'Total Images',
                    'count' => MediaFile::where('user_id', $userId)->whereIn('file_type', $imageTypes)->count(),
                    'icon' => 'photo',
                    'color' => 'bg-green-100 text-green-600',
                    'desc' => 'Image files in your storage',
                ],
                [
                    'label' => 'Total Videos',
                    'count' => MediaFile::where('user_id', $userId)->whereIn('file_type', $videoTypes)->count(),
                    'icon' => 'video-camera',
                    'color' => 'bg-red-100 text-red-600',
                    'desc' => 'Video files in your storage',
                ],
                [
                    'label' => 'Total Audios',
                    'count' => MediaFile::where('user_id', $userId)->whereIn('file_type', $audioTypes)->count(),
                    'icon' => 'musical-note',
                    'color' => 'bg-blue-100 text-blue-600',
                    'desc' => 'Audio files in your storage',
                ],
                [
                    'label' => 'Total Documents',
                    'count' => MediaFile::where('user_id', $userId)->whereIn('file_type', $docTypes)->count(),
                    'icon' => 'document-text',
                    'color' => 'bg-yellow-100 text-yellow-600',
                    'desc' => 'Document files in your storage',
                ],
                [
                    'label' => 'Other Files',
                    'count' => MediaFile::where('user_id', $userId)->whereNotIn('file_type', $excludedTypes)->count(),
                    'icon' => 'archive-box',
                    'color' => 'bg-gray-200 text-gray-700',
                    'desc' => 'Other files in your storage',
                ],
            ],
        ];
    }
}
