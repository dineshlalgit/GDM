<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorageRequestResource\Pages;
use App\Filament\Resources\StorageRequestResource\RelationManagers;
use App\Models\StorageRequest;
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
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;

class StorageRequestResource extends Resource
{
    protected static ?string $model = StorageRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';

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
                TextColumn::make('user.name')->label('Requested By')->sortable()->searchable(),
                TextColumn::make('user.role.name')->label('Role')->sortable(),
                TextColumn::make('amount_gb')->label('Amount (GB)')->sortable(),
                TextColumn::make('reason')->label('Reason')->limit(40),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('accept')
                    ->label('Accept')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(fn($record) => $record->update(['status' => 'approved'])),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(fn($record) => $record->update(['status' => 'rejected'])),
                ViewAction::make(),
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
            'index' => Pages\ListStorageRequests::route('/'),
            'view' => Pages\ViewStorageRequest::route('/{record}'),
            // 'create' => Pages\CreateStorageRequest::route('/create'),
            // 'edit' => Pages\EditStorageRequest::route('/{record}/edit'),
        ];
    }
}
