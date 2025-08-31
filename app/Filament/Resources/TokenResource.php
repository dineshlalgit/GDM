<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TokenResource\Pages;
use App\Models\Token;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

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
                Forms\Components\Section::make('Token Information')
                    ->schema([
                        Forms\Components\TextInput::make('token_code')
                            ->label('Token Code')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Unique token identifier'),
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('contact_number')
                            ->label('Contact Number')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('balance_amount')
                            ->label('Balance Amount')
                            ->prefix('₹')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('status')
                            ->options([
                                'generated' => 'Generated',
                                'used' => 'Used',
                            ])
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Generated Date')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\DateTimePicker::make('updated_at')
                            ->label('Last Updated')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
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
                    ->copyMessageDuration(1500)
                    ->weight('bold')
                    ->size(TextColumn\TextColumnSize::Large),
                TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Medium),
                TextColumn::make('contact_number')
                    ->label('Contact Number')
                    ->searchable()
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Medium),
                TextColumn::make('balance_amount')
                    ->label('Amount')
                    ->money('INR')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Medium),
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
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Small),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Small),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'generated' => 'Generated',
                        'used' => 'Used',
                    ])
                    ->label('Filter by Status'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->label('Filter by Date Range'),
            ])
            ->actions([
                Action::make('viewDetails')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn (Token $record): string => route('filament.owner.resources.tokens.view', $record))
                    ->openUrlInNewTab(false),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100])
            ->searchable()
            ->striped();
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
            'view' => Pages\ViewToken::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
}
