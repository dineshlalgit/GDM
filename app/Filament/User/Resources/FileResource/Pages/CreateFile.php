<?php

namespace App\Filament\User\Resources\FileResource\Pages;

use App\Filament\User\Resources\FileResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CreateFile extends CreateRecord
{
    protected static string $resource = FileResource::class;



    protected function afterCreate(): void
    {
        $record = $this->record;
        $disk = 'public';

        if ($record->file_path && Storage::disk($disk)->exists($record->file_path)) {
            $mime = Storage::disk($disk)->mimeType($record->file_path); // e.g. "image/png"

            // Extract extension from mime type
            $extension = explode('/', $mime)[1] ?? 'unknown';

            Log::info('[CreateFile] File extension set.', [
                'mime' => $mime,
                'extension' => $extension,
            ]);

            $record->file_type = $extension; // Save just "png", "jpeg", etc.
            $record->saveQuietly();
        }
    }






}
