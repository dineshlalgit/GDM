<?php

namespace App\Filament\Admin\Resources\StorageRequestResource\Pages;

use App\Filament\Admin\Resources\StorageRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorageRequests extends ListRecords
{
    protected static string $resource = StorageRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
