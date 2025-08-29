<?php

namespace App\Filament\User\Resources\GymBookingResource\Pages;

use App\Filament\User\Resources\GymBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGymBooking extends EditRecord
{
    protected static string $resource = GymBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
