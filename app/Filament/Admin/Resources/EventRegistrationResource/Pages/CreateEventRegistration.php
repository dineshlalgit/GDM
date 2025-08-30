<?php

namespace App\Filament\Admin\Resources\EventRegistrationResource\Pages;

use App\Filament\Admin\Resources\EventRegistrationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventRegistration extends CreateRecord
{
    protected static string $resource = EventRegistrationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Event registration created successfully!';
    }
}
