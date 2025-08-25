<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StorageRequestResource\Pages;
use App\Filament\Admin\Resources\StorageRequestResource\RelationManagers;
use App\Models\StorageRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Models\Role;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Auth;

class StorageRequestResource extends Resource
{
    protected static ?string $model = StorageRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
                TextInput::make('amount_gb')
                    ->label('Additional Storage Needed (GB)')
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('e.g., 100')
                    ->required(),
                Textarea::make('reason')
                    ->label('Reason for Request')
                    ->placeholder('Explain why you need additional storage...')
                    ->rows(3)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount_gb')->label('Amount (GB)')->sortable(),
                TextColumn::make('reason')->label('Reason')->limit(40),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('created_at')->label('Requested At')->dateTime()->sortable(),
            ])
            ->filters([
                // No filters needed for user view
            ])
            ->actions([
                // No actions for user, only view
            ])
            ->bulkActions([
                // No bulk actions for user
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        // Only show requests belonging to the current user
        return parent::getEloquentQuery()->where('user_id', Auth::id());
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
            'index' => Pages\ListStorageRequests::route('/'),
            'create' => Pages\CreateStorageRequest::route('/create'),
            'edit' => Pages\EditStorageRequest::route('/{record}/edit'),
        ];
    }
}
