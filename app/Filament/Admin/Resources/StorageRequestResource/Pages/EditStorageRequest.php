<?php

namespace App\Filament\Admin\Resources\StorageRequestResource\Pages;

use App\Filament\Admin\Resources\StorageRequestResource;
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
