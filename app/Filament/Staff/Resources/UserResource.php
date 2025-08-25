<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\UserResource\Pages;
use App\Filament\Staff\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrated(fn($state) => filled($state)),
                Forms\Components\TextInput::make('quota')
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
                Forms\Components\Toggle::make('active')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->default(true)
                    ->inline(false)
                    ->required(),
                Forms\Components\Hidden::make('role_id')
                    ->default(function () {
                        // Set the default role to 'user'
                        $role = \App\Models\Role::where('name', 'user')->first();
                        return $role ? $role->id : null;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                \Filament\Tables\Columns\ViewColumn::make('storage_usage')
                    ->label('Storage Usage')
                    ->view('components.storage-usage-bar')
                    ->getStateUsing(function ($record) {
                        return [
                            'used' => $record->used_storage ?? 0,
                            'quota' => $record->quota ?? 1,
                        ];
                    }),
                Tables\Columns\BadgeColumn::make('active')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Active' : 'Suspended')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->icon(fn($state) => $state ? 'heroicon-o-check' : 'heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('role', function ($query) {
            $query->where('name', 'user');
        });
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
