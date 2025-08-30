<?php

namespace App\Filament\Admin\Resources\EventRegistrationResource\Pages;

use App\Filament\Admin\Resources\EventRegistrationResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions\Action;

class ViewEventRegistration extends ViewRecord
{
    protected static string $resource = EventRegistrationResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('User Information')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Full Name')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        TextEntry::make('user.email')
                            ->label('Email Address')
                            ->icon('heroicon-m-envelope'),

                        TextEntry::make('user.role.name')
                            ->label('User Role')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('user.created_at')
                            ->label('User Since')
                            ->dateTime('M d, Y'),
                    ])
                    ->columns(2),

                Section::make('Event Information')
                    ->schema([
                        TextEntry::make('event.name')
                            ->label('Event Name')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        TextEntry::make('event.type')
                            ->label('Event Type')
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
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                        TextEntry::make('event.description')
                            ->label('Event Description')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('event.event_datetime')
                            ->label('Event Date & Time')
                            ->dateTime('M d, Y g:i A')
                            ->icon('heroicon-m-calendar'),

                        TextEntry::make('event.location')
                            ->label('Event Location')
                            ->icon('heroicon-m-map-pin'),

                        TextEntry::make('event.status')
                            ->label('Event Status')
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'open' => 'success',
                                'closed' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                    ])
                    ->columns(2),

                Section::make('Registration Details')
                    ->schema([
                        TextEntry::make('registered_at')
                            ->label('Registration Date')
                            ->dateTime('M d, Y g:i A')
                            ->icon('heroicon-m-clock'),

                        TextEntry::make('status')
                            ->label('Registration Status')
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'registered' => 'info',
                                'attended' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                        TextEntry::make('notes')
                            ->label('Notes')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('M d, Y g:i A'),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('M d, Y g:i A'),
                    ])
                    ->columns(2),
            ]);
    }
}
