<?php

namespace App\Filament\User\Resources\FileResource\Pages;

use App\Filament\User\Resources\FileResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EditFile extends EditRecord
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        Log::info('[EditFile] afterSave triggered.', ['file_path' => $this->record->file_path]);

        $record = $this->record;
        $disk = 'public'; // Make sure this matches your FileUpload

        if ($record->file_path && Storage::disk($disk)->exists($record->file_path)) {
            $mime = Storage::disk($disk)->mimeType($record->file_path);
            $extension = explode('/', $mime)[1] ?? 'unknown';

            Log::info('[EditFile] File type resolved.', [
                'mime' => $mime,
                'extension' => $extension,
            ]);

            $record->file_type = $extension;
            $record->saveQuietly();
        } else {
            Log::warning('[EditFile] File not found in storage.', [
                'path' => $record->file_path,
                'disk' => $disk,
            ]);
        }
    }
}
