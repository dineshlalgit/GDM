<?php

namespace App\Filament\User\Resources\GymTimeSlotResource\Pages;

use App\Filament\User\Resources\GymTimeSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGymTimeSlot extends EditRecord
{
    protected static string $resource = GymTimeSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
