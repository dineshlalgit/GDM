<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\GymTimeSlotResource\Pages;
use App\Filament\User\Resources\GymTimeSlotResource\RelationManagers;
use App\Models\GymTimeSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GymTimeSlotResource extends Resource
{
    protected static ?string $model = GymTimeSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Panel::make([
                    Tables\Columns\TextColumn::make('time_range')
                        ->label('')
                        ->state(fn (GymTimeSlot $record) => \Illuminate\Support\Carbon::parse($record->start_time)->format('H:i') . ' - ' . \Illuminate\Support\Carbon::parse($record->end_time)->format('H:i'))
                        ->weight('bold'),
                    // Tables\Columns\TextColumn::make('capacity')
                    //     ->label('Capacity'),
                    Tables\Columns\TextColumn::make('booked_summary')
                        ->label('Booked/Remaining')
                        ->state(fn (GymTimeSlot $record) => $record->getBookedCount().' / '.max(0, $record->capacity - $record->getBookedCount())),
                    Tables\Columns\BadgeColumn::make('status')
                        ->label('Status')
                        ->state(fn (GymTimeSlot $record) => $record->isFull() ? 'Full' : 'Available')
                        ->colors([
                            'danger' => 'Full',
                            'success' => 'Available',
                        ]),
                ]),
            ])
            ->contentGrid([
                'sm' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('toggleBooking')
                    ->button()
                    ->size('sm')
                    ->label(function (GymTimeSlot $record) {
                        $userId = Auth::id();
                        if (!$userId) return 'Book';
                        $booking = $record->bookings()->where('user_id', $userId)->latest()->first();
                        if (!$booking) return 'Book';
                        if ($booking->status === 'confirmed') return 'Cancel Booking';
                        return 'Under Review';
                    })
                    ->icon(function (GymTimeSlot $record) {
                        $userId = Auth::id();
                        if (!$userId) return 'heroicon-m-plus-circle';
                        $booking = $record->bookings()->where('user_id', $userId)->latest()->first();
                        if (!$booking) return 'heroicon-m-plus-circle';
                        if ($booking->status === 'confirmed') return 'heroicon-m-x-mark';
                        return 'heroicon-m-clock';
                    })
                    ->color(function (GymTimeSlot $record) {
                        $userId = Auth::id();
                        if (!$userId) return 'success';
                        $booking = $record->bookings()->where('user_id', $userId)->latest()->first();
                        if (!$booking) return 'success';
                        if ($booking->status === 'confirmed') return 'danger';
                        return 'warning';
                    })
                    ->tooltip(function (GymTimeSlot $record) {
                        $userId = Auth::id();
                        if (!$userId) return 'Book this time slot';
                        $booking = $record->bookings()->where('user_id', $userId)->latest()->first();
                        if (!$booking) return 'Book this time slot';
                        if ($booking->status === 'confirmed') return 'Cancel your booking for this slot';
                        return 'Your booking is under review';
                    })
                    ->disabled(function (GymTimeSlot $record) {
                        $userId = Auth::id();
                        $booking = $userId ? $record->bookings()->where('user_id', $userId)->latest()->first() : null;
                        // When pending, disable. When none, disable only if full. When confirmed, enable to allow cancel.
                        if ($booking && $booking->status === 'pending') return true;
                        if (!$booking) return $record->isFull();
                        return false;
                    })
                    ->action(function (GymTimeSlot $record): void {
                        $userId = Auth::id();
                        if (!$userId) {
                            return;
                        }

                        $existing = $record->bookings()->where('user_id', $userId)->latest()->first();

                        if ($existing) {
                            if ($existing->status === 'confirmed') {
                                // Cancel only if confirmed
                                $existing->delete();
                            }
                            return; // Do nothing when pending
                        }

                        // Create booking if not full
                        if ($record->isFull()) {
                            return;
                        }

                        \App\Models\GymBooking::create([
                            'user_id' => $userId,
                            'gym_time_slot_id' => $record->id,
                            // status defaults to 'pending'
                        ]);
                    })
                    ->visible(fn () => Auth::check()),
            ])
            ->bulkActions([])
            ->defaultSort('start_time');
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
            'index' => Pages\ListGymTimeSlots::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('is_active', true);
    }
}
