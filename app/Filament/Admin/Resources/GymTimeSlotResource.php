<?php

namespace App\Filament\Admin\Resources;

use App\Models\GymTimeSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Carbon;

class GymTimeSlotResource extends Resource
{
	protected static ?string $model = GymTimeSlot::class;

	protected static ?string $navigationIcon = 'heroicon-o-clock';
	protected static ?string $navigationGroup = 'Gym Management';
	protected static ?int $navigationSort = 1;

	public static function form(Form $form): Form
	{
		return $form->schema([
			Forms\Components\TimePicker::make('start_time')->seconds(false)->required(),
			Forms\Components\TimePicker::make('end_time')->seconds(false)->required(),
			Forms\Components\TextInput::make('capacity')->numeric()->minValue(1)->default(20)->required(),
			Forms\Components\Toggle::make('is_active')->default(true),
		]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\Layout\Panel::make([
					Tables\Columns\TextColumn::make('time_range')
						->label('')
						->state(fn (GymTimeSlot $record) => \Illuminate\Support\Carbon::parse($record->start_time)->format('H:i').' - '.\Illuminate\Support\Carbon::parse($record->end_time)->format('H:i'))
						->weight('bold'),
					// Tables\Columns\TextColumn::make('capacity'),

					Tables\Columns\TextColumn::make('booked')->label('Booked')
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
			->headerActions([
				Action::make('generateSlots')
					->label('Generate Slots')
					->form([
						Forms\Components\TimePicker::make('from')->seconds(false)->default('06:00')->required(),
						Forms\Components\TimePicker::make('to')->seconds(false)->default('21:00')->required(),
						Forms\Components\TextInput::make('duration')->numeric()->minValue(30)->default(60)->required()->helperText('Minutes per slot'),
						Forms\Components\TextInput::make('capacity')->numeric()->minValue(1)->default(20)->required(),
					])
					->action(function (array $data) {
						$start = Carbon::parse($data['from']);
						$end = Carbon::parse($data['to']);
						$duration = (int) $data['duration'];
						while ($start->lt($end)) {
							$slotEnd = (clone $start)->addMinutes($duration);
							GymTimeSlot::firstOrCreate([
								'start_time' => $start->format('H:i:s'),
								'end_time' => $slotEnd->format('H:i:s'),
							], [
								'capacity' => (int) $data['capacity'],
								'is_active' => true,
							]);
							$start = $slotEnd;
						}
					}),
			])
			->actions([
				Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
			])
			->defaultSort('start_time');
	}

	public static function getPages(): array
	{
		return [
			'index' => GymTimeSlotResource\Pages\ListGymTimeSlots::route('/'),
			'create' => GymTimeSlotResource\Pages\CreateGymTimeSlot::route('/create'),
			'edit' => GymTimeSlotResource\Pages\EditGymTimeSlot::route('/{record}/edit'),
		];
	}
}


