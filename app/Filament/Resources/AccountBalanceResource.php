<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountBalanceResource\Pages;
use App\Models\AccountBalance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AccountBalanceResource extends Resource
{
    protected static ?string $model = AccountBalance::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Financial Management';

    protected static ?string $modelLabel = 'Account Balance';

    protected static ?string $pluralModelLabel = 'Account Balances';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Daily Account Balance')
                    ->description('Update today\'s account balance and financial details')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Date')
                            ->default(today())
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Select the date for this balance entry'),
                        Forms\Components\TextInput::make('opening_balance')
                            ->label('Opening Balance')
                            ->required()
                            ->numeric()
                            ->prefix('₹')
                            ->minValue(0)
                            ->step(0.01)
                            ->helperText('Starting balance for the day'),
                        Forms\Components\TextInput::make('total_income')
                            ->label('Total Income')
                            ->required()
                            ->numeric()
                            ->prefix('₹')
                            ->minValue(0)
                            ->step(0.01)
                            ->default(0)
                            ->helperText('Total income received today'),
                        Forms\Components\TextInput::make('total_expenses')
                            ->label('Total Expenses')
                            ->required()
                            ->numeric()
                            ->prefix('₹')
                            ->minValue(0)
                            ->step(0.01)
                            ->default(0)
                            ->helperText('Total expenses incurred today'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->placeholder('Any additional notes about today\'s financial activities')
                            ->helperText('Optional notes for reference'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('opening_balance')
                    ->label('Opening Balance')
                    ->money('INR')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Medium),
                TextColumn::make('total_income')
                    ->label('Income')
                    ->money('INR')
                    ->color('success')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Medium),
                TextColumn::make('total_expenses')
                    ->label('Expenses')
                    ->money('INR')
                    ->color('danger')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Medium),
                TextColumn::make('net_change')
                    ->label('Net Change')
                    ->money('INR')
                    ->color(fn (string $state): string =>
                        floatval($state) >= 0 ? 'success' : 'danger'
                    )
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Medium),
                TextColumn::make('closing_balance')
                    ->label('Closing Balance')
                    ->money('INR')
                    ->weight('bold')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Large),
                TextColumn::make('updated_by')
                    ->label('Updated By')
                    ->formatStateUsing(fn ($state) => $state->name ?? 'N/A')
                    ->size(TextColumn\TextColumnSize::Small),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Small),
            ])
            ->filters([
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from_date')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('to_date')
                            ->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['to_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
                    ->label('Filter by Date Range'),
            ])
            ->actions([
                ViewAction::make()
                    ->label('View Details')
                    ->icon('heroicon-o-eye'),
                EditAction::make()
                    ->label('Edit Balance')
                    ->icon('heroicon-o-pencil'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc')
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
            'index' => Pages\ListAccountBalances::route('/'),
            'create' => Pages\CreateAccountBalance::route('/create'),
            'edit' => Pages\EditAccountBalance::route('/{record}/edit'),
            'view' => Pages\ViewAccountBalance::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
