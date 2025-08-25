<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Storage;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrated(fn($state) => filled($state)),

                TextInput::make('quota')
                    ->label('Storage Quota (GB)')
                    ->numeric()
                    ->minValue(1)
                    ->default(5)
                    ->maxValue(function () {
                        $mediaPath = storage_path('app/public/media');
                        $free = @disk_free_space($mediaPath);
                        if ($free === false) return null;
                        return floor($free / (1024 * 1024 * 1024));
                    })
                    ->helperText(function () {
                        $mediaPath = storage_path('app/public/media');
                        $free = @disk_free_space($mediaPath);
                        if ($free === false) return 'Unable to determine available space.';
                        $freeGB = floor($free / (1024 * 1024 * 1024));
                        return "Set the user's storage quota in GB. Cannot exceed available free space. Available: {$freeGB} GB free.";
                    })
                    ->dehydrateStateUsing(fn($state) => filled($state) ? $state * 1024 * 1024 * 1024 : 5 * 1024 * 1024 * 1024)
                    ->formatStateUsing(function ($state, $record, $component) {
                        // For new records, always show 5
                        if (is_null($record) || is_null($record->getKey())) {
                            return 5;
                        }
                        // Otherwise, convert bytes to GB
                        return round($state / (1024 * 1024 * 1024), 2);
                    }),

                Select::make('role_id')
                    ->label('Role')
                    ->options(fn() => Role::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Toggle::make('active')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->default(true)
                    ->inline(false)
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                BadgeColumn::make('role.name')
                    ->label('Role')
                    ->colors([
                        'primary' => 'Owner',
                        'danger' => 'Admin',
                        'info' => 'Staff',
                        'success' => 'User',
                    ]),
                \Filament\Tables\Columns\ViewColumn::make('storage_usage')
                    ->label('Storage Usage')
                    ->view('components.storage-usage-bar')
                    ->getStateUsing(function ($record) {
                        return [
                            'used' => $record->used_storage ?? 0,
                            'quota' => $record->quota ?? 1,
                        ];
                    }),
                TextColumn::make('created_at')->dateTime()->sortable(),
                \Filament\Tables\Columns\BadgeColumn::make('active')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Suspended')
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->icon(fn ($state) => $state ? 'heroicon-o-check' : 'heroicon-o-x-mark'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
