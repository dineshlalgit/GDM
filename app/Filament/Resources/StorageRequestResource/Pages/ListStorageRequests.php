<?php

namespace App\Filament\Resources\StorageRequestResource\Pages;

use App\Filament\Resources\StorageRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorageRequests extends ListRecords
{
    protected static string $resource = StorageRequestResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
