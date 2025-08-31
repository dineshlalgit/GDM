<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TokenResource\Pages;
use App\Models\Token;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Token Management';

    protected static ?string $modelLabel = 'Token';

    protected static ?string $pluralModelLabel = 'Tokens';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Customer Name'),
                Forms\Components\TextInput::make('contact_number')
                    ->required()
                    ->maxLength(20)
                    ->label('Contact Number')
                    ->tel(),
                Forms\Components\TextInput::make('balance_amount')
                    ->required()
                    ->numeric()
                    ->prefix('₹')
                    ->minValue(0.01)
                    ->step(0.01)
                    ->label('Balance Amount'),
                Forms\Components\Select::make('status')
                    ->options([
                        'generated' => 'Generated',
                        'used' => 'Used',
                    ])
                    ->default('generated')
                    ->required()
                    ->label('Status'),
                Forms\Components\TextInput::make('token_code')
                    ->disabled()
                    ->dehydrated(false)
                    ->label('Token Code')
                    ->helperText('Token code will be automatically generated'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('token_code')
                    ->label('Token Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Token code copied!')
                    ->copyMessageDuration(1500),
                TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_number')
                    ->label('Contact Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('balance_amount')
                    ->label('Amount')
                    ->money('INR')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'generated',
                        'success' => 'used',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('created_at')
                    ->label('Generated Date')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'generated' => 'Generated',
                        'used' => 'Used',
                    ])
                    ->label('Filter by Status'),
            ])
            ->actions([
                ViewAction::make()
                    ->label('View Token')
                    ->url(fn (Token $record): string => route('tokens.view', $record))
                    ->openUrlInNewTab(),
                EditAction::make()
                    ->label('Edit Token'),
                Action::make('markAsUsed')
                    ->label('Mark as Used')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Mark Token as Used')
                    ->modalDescription('Are you sure you want to mark this token as used? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, mark as used')
                    ->action(function (Token $record) {
                        $record->update(['status' => 'used']);
                    })
                    ->visible(fn (Token $record): bool => $record->status === 'generated'),
                DeleteAction::make()
                    ->label('Delete Token'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListTokens::route('/'),
            'create' => Pages\CreateToken::route('/create'),
            'edit' => Pages\EditToken::route('/{record}/edit'),
            'view' => Pages\ViewToken::route('/{record}'),
        ];
    }
}
