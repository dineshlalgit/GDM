<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Events Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Event Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Event Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter event name'),

                        Forms\Components\Select::make('type')
                            ->label('Event Type')
                            ->required()
                            ->options([
                                'meeting' => 'Meeting',
                                'workshop' => 'Workshop',
                                'training' => 'Training',
                                'celebration' => 'Celebration',
                                'seminar' => 'Seminar',
                                'conference' => 'Conference',
                                'other' => 'Other',
                            ])
                            ->searchable()
                            ->placeholder('Select event type')
                            ->native(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->rows(4)
                            ->placeholder('Describe the event details'),

                        Forms\Components\DateTimePicker::make('event_datetime')
                            ->label('Event Date & Time')
                            ->required()
                            ->minDate(now())
                            ->format('Y-m-d H:i')
                            ->displayFormat('M d, Y g:i A')
                            ->placeholder('Select event date and time'),

                        Forms\Components\TextInput::make('location')
                            ->label('Location')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter event location'),
                    ])
                    ->columns(2),
            ]);
    }

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
                    ->color(fn (string $state): string => match($state) {
                        'open' => 'success',
                        'closed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable()
                    ->badge()
                    ->extraAttributes(fn ($record) => [
                        'class' => $record && $record->isPast() && $record->status === 'open'
                            ? 'bg-yellow-100 text-yellow-800 border-yellow-200'
                            : ''
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
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
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
