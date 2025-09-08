<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\EventRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Events';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Event Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'meeting',
                        'success' => 'workshop',
                        'info' => 'training',
                        'warning' => 'celebration',
                        'danger' => 'seminar',
                        'purple' => 'conference',
                        'gray' => 'other',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event_datetime')
                    ->label('Date & Time')
                    ->dateTime('M d, Y g:i A')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'open',
                        'danger' => 'closed',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                // Tables\Columns\TextColumn::make('registration_count')
                //     ->label('Registrations')
                //     ->counts('registrations')
                //     ->sortable(),


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Event Type')
                    ->options([
                        'meeting' => 'Meeting',
                        'workshop' => 'Workshop',
                        'training' => 'Training',
                        'celebration' => 'Celebration',
                        'seminar' => 'Seminar',
                        'conference' => 'Conference',
                        'other' => 'Other',
                    ]),

                Tables\Filters\Filter::make('upcoming')
                    ->label('Upcoming Events')
                    ->query(fn (Builder $query): Builder => $query->where('event_datetime', '>', now())),

                Tables\Filters\Filter::make('past')
                    ->label('Past Events')
                    ->query(fn (Builder $query): Builder => $query->where('event_datetime', '<', now())),
            ])
            ->actions([

                Action::make('register')
                    ->label('Register')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->visible(fn (Event $record): bool =>
                        $record->status === 'open' &&
                        !$record->isUserRegistered(Auth::id())
                    )
                    ->action(function (Event $record) {
                        EventRegistration::create([
                            'user_id' => Auth::id(),
                            'event_id' => $record->id,
                            'registered_at' => now(),
                            'status' => 'registered',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Registration')
                    ->modalDescription(fn (Event $record) => "Are you sure you want to register for '{$record->name}'?")
                    ->modalSubmitActionLabel('Yes, Register'),

                Action::make('registered')
                    ->label('Registered')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->disabled()
                    ->visible(fn (Event $record): bool =>
                        $record->isUserRegistered(Auth::id())
                    ),

                    Tables\Actions\ViewAction::make()
                    ->label('View Details')
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([])
            ->defaultSort('event_datetime', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'view' => Pages\ViewEvent::route('/{record}'),
        ];
    }
}
