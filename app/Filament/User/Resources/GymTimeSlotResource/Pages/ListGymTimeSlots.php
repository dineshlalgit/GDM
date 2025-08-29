<?php

namespace App\Filament\User\Resources\GymTimeSlotResource\Pages;

use App\Filament\User\Resources\GymTimeSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGymTimeSlots extends ListRecords
{
    protected static string $resource = GymTimeSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
