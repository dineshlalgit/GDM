<?php

namespace App\Filament\Resources\StorageRequestResource\Pages;

use App\Filament\Resources\StorageRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorageRequest extends EditRecord
{
    protected static string $resource = StorageRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
