<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\MediaFile;

class OwnerFilesStatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.owner-files-stats-widget';

    public function getViewData(): array
    {
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $videoTypes = ['mp4', 'mov', 'avi'];
        $audioTypes = ['mp3', 'wav', 'ogg'];
        $docTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
        $excludedTypes = array_merge($imageTypes, $videoTypes, $audioTypes, $docTypes);

        $total = MediaFile::count();
        $images = MediaFile::whereIn('file_type', $imageTypes)->count();
        $videos = MediaFile::whereIn('file_type', $videoTypes)->count();
        $audios = MediaFile::whereIn('file_type', $audioTypes)->count();
        $docs = MediaFile::whereIn('file_type', $docTypes)->count();
        $others = MediaFile::whereNotIn('file_type', $excludedTypes)->count();

        // Debug: get all unique file_type values
        $allTypes = MediaFile::distinct()->pluck('file_type')->toArray();

        return [
            'stats' => [
                [
                    'label' => 'Total Files',
                    'count' => $total,
                    'icon' => 'archive-box',
                    'desc' => 'All files in the system',
                ],
                [
                    'label' => 'Total Images',
                    'count' => $images,
                    'icon' => 'photo',
                    'desc' => 'Image files',
                ],
                [
                    'label' => 'Total Videos',
                    'count' => $videos,
                    'icon' => 'video-camera',
                    'desc' => 'Video files',
                ],
                [
                    'label' => 'Total Audios',
                    'count' => $audios,
                    'icon' => 'musical-note',
                    'desc' => 'Audio files',
                ],
                [
                    'label' => 'Total Documents',
                    'count' => $docs,
                    'icon' => 'document-text',
                    'desc' => 'Document files',
                ],
                [
                    'label' => 'Other Files',
                    'count' => $others,
                    'icon' => 'archive-box',
                    'desc' => 'Other file types',
                ],
            ],
            'debug_types' => $allTypes,
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
