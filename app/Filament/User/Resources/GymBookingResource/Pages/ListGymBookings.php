<?php

namespace App\Filament\User\Resources\GymBookingResource\Pages;

use App\Filament\User\Resources\GymBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGymBookings extends ListRecords
{
    protected static string $resource = GymBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
