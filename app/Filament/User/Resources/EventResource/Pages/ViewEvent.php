<?php

namespace App\Filament\User\Resources\EventResource\Pages;

use App\Filament\User\Resources\EventResource;
use App\Models\EventRegistration;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        $record = $this->getRecord();

        // Only show register button if event is open and user is not registered
        if ($record->status === 'open' && !$record->isUserRegistered(Auth::id())) {
            return [
                Action::make('register')
                    ->label('Register for Event')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->action(function () use ($record) {
                        EventRegistration::create([
                            'user_id' => Auth::id(),
                            'event_id' => $record->id,
                            'registered_at' => now(),
                            'status' => 'registered',
                        ]);

                        Notification::make()
                            ->title('Registration Successful')
                            ->body('You have been successfully registered for the event!')
                            ->success()
                            ->send();

                        // Redirect back to the events list
                        return redirect()->route('filament.user.resources.events.index');
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Registration')
                    ->modalDescription("Are you sure you want to register for '{$record->name}'?")
                    ->modalSubmitActionLabel('Yes, Register'),
            ];
        }

        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Event Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Event Name')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        TextEntry::make('type')
                            ->label('Event Type')
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'meeting' => 'primary',
                                'workshop' => 'success',
                                'training' => 'info',
                                'celebration' => 'warning',
                                'seminar' => 'danger',
                                'conference' => 'purple',
                                'other' => 'gray',
                                default => 'gray',
                            }),

                        TextEntry::make('description')
                            ->label('Description')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('event_datetime')
                            ->label('Date & Time')
                            ->dateTime('M d, Y g:i A'),

                        TextEntry::make('location')
                            ->label('Location'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'open' => 'success',
                                'closed' => 'gray',
                                default => 'gray',
                            }),

                        TextEntry::make('registration_count')
                            ->label('Total Registrations')
                            ->state(fn ($record) => $record->registrations()->count()),
                    ])
                    ->columns(2),

                Section::make('Registration Status')
                    ->schema([
                        TextEntry::make('registration_status')
                            ->label('Your Status')
                            ->state(function ($record) {
                                if ($record->isUserRegistered(Auth::id())) {
                                    return 'Registered';
                                }
                                return 'Not Registered';
                            })
                            ->badge()
                            ->color(fn ($record) => $record->isUserRegistered(Auth::id()) ? 'success' : 'gray'),

                        TextEntry::make('can_register')
                            ->label('Registration Available')
                            ->state(function ($record) {
                                if ($record->status === 'closed') {
                                    return 'Event Closed';
                                }
                                if ($record->isUserRegistered(Auth::id())) {
                                    return 'Already Registered';
                                }
                                return 'Open for Registration';
                            })
                            ->badge()
                            ->color(fn ($record) => match(true) {
                                $record->status === 'closed' => 'danger',
                                $record->isUserRegistered(Auth::id()) => 'success',
                                default => 'info',
                            }),
                    ])
                    ->columns(2),
            ]);
    }
}
