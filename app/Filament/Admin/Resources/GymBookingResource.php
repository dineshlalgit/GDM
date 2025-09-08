<?php

namespace App\Filament\Admin\Resources;

use App\Models\GymBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class GymBookingResource extends Resource
{
	protected static ?string $model = GymBooking::class;

	protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
	protected static ?string $navigationGroup = 'Gym Management';
	protected static ?int $navigationSort = 2;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Forms\Components\Select::make('user_id')
					->relationship('user', 'name')
					->searchable()
					->required(),
				Forms\Components\Select::make('gym_time_slot_id')
					->relationship('timeSlot', 'id')
					->required(),
				Forms\Components\Select::make('status')
					->options([
						'pending' => 'pending',
						'confirmed' => 'confirmed',
						'cancelled' => 'cancelled',
					])
					->required(),
				Forms\Components\Textarea::make('special_requests')
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('user.name')->label('User')->searchable(),
				Tables\Columns\TextColumn::make('created_at')->date()->label('Date'),
				Tables\Columns\TextColumn::make('timeSlot.start_time')
					->label('Time Slot')
					->formatStateUsing(function ($state, $record) {
						$start = $record->timeSlot?->start_time;
						$end = $record->timeSlot?->end_time;
						if (!$start || !$end) {
							return '-';
						}
						try {
							$startStr = \Illuminate\Support\Carbon::parse($start)->format('H:i');
							$endStr = \Illuminate\Support\Carbon::parse($end)->format('H:i');
							return $startStr.' - '.$endStr;
						} catch (\Throwable $e) {
							return (string) $start.' - '.(string) $end;
						}
					}),
				Tables\Columns\TextColumn::make('status')->badge()->colors([
					'warning' => 'pending',
					'success' => 'confirmed',
					'danger' => 'cancelled',
				]),
				Tables\Columns\TextColumn::make('created_at')->label('Booked On')->date(),
				Tables\Columns\TextColumn::make('special_requests')->toggleable(isToggledHiddenByDefault: true),
			])
			->actions([
				Tables\Actions\Action::make('confirm')
					->visible(fn (GymBooking $record) => $record->status === 'pending')
					->color('success')
					->action(fn (GymBooking $record) => $record->update(['status' => 'confirmed'])),
				Tables\Actions\Action::make('cancel')
					->label(fn (GymBooking $record) => $record->status === 'confirmed' ? 'End Membership' : 'Cancel')
					->visible(fn (GymBooking $record) => in_array($record->status, ['pending','confirmed']))
					->color('danger')
					->action(function (GymBooking $record) {
						$record->delete();
					}),
			])
			->bulkActions([
				Tables\Actions\BulkAction::make('confirmAll')
					->label('Confirm Selected')
					->action(fn ($records) => $records->each->update(['status' => 'confirmed']))
					->color('success'),
				Tables\Actions\BulkAction::make('cancelAll')
					->label('Cancel Selected')
					->action(fn ($records) => $records->each->delete())
					->color('danger'),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => GymBookingResource\Pages\ListGymBookings::route('/'),
		];
	}
}


