<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EventRegistrationResource\Pages;
use App\Models\EventRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventRegistrationResource extends Resource
{
    protected static ?string $model = EventRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Events Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Event Registrations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->placeholder('Add any notes about this registration'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('User Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event.name')
                    ->label('Event Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('event.type')
                    ->label('Event Type')
                    ->colors([
                        'primary' => 'meeting',
                        'success' => 'workshop',
                        'info' => 'training',
                        'warning' => 'celebration',
                        'danger' => 'seminar',
                        'purple' => 'conference',
                        'gray' => 'other',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('event.event_datetime')
                    ->label('Event Date & Time')
                    ->dateTime('M d, Y g:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('registered_at')
                    ->label('Registration Date')
                    ->dateTime('M d, Y g:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event.type')
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

                Tables\Filters\Filter::make('upcoming_events')
                    ->label('Upcoming Events')
                    ->query(fn (Builder $query): Builder => $query->whereHas('event', function ($q) {
                        $q->where('event_datetime', '>', now());
                    })),

                Tables\Filters\Filter::make('past_events')
                    ->label('Past Events')
                    ->query(fn (Builder $query): Builder => $query->whereHas('event', function ($q) {
                        $q->where('event_datetime', '<', now());
                    })),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Details'),
            ])
            ->bulkActions([])
            ->defaultSort('registered_at', 'desc');
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
            'index' => Pages\ListEventRegistrations::route('/'),
            'view' => Pages\ViewEventRegistration::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
