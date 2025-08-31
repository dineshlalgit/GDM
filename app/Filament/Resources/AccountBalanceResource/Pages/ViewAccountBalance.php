<?php

namespace App\Filament\Resources\AccountBalanceResource\Pages;

use App\Filament\Resources\AccountBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;

class ViewAccountBalance extends ViewRecord
{
    protected static string $resource = AccountBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Account Balance Details')
                    ->description('Complete financial information for the selected date')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('date')
                                    ->label('Date')
                                    ->date('d M Y')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),
                                TextEntry::make('updated_by')
                                    ->label('Updated By')
                                    ->formatStateUsing(fn ($state) => $state->name ?? 'N/A')
                                    ->size(TextEntry\TextEntrySize::Medium),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('opening_balance')
                                    ->label('Opening Balance')
                                    ->money('INR')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),
                                TextEntry::make('closing_balance')
                                    ->label('Closing Balance')
                                    ->money('INR')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('total_income')
                                    ->label('Total Income')
                                    ->money('INR')
                                    ->color('success')
                                    ->size(TextEntry\TextEntrySize::Medium),
                                TextEntry::make('total_expenses')
                                    ->label('Total Expenses')
                                    ->money('INR')
                                    ->color('danger')
                                    ->size(TextEntry\TextEntrySize::Medium),
                            ]),
                        TextEntry::make('net_change')
                            ->label('Net Change')
                            ->money('INR')
                            ->color(fn (string $state): string =>
                                floatval($state) >= 0 ? 'success' : 'danger'
                            )
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        TextEntry::make('notes')
                            ->label('Notes')
                            ->size(TextEntry\TextEntrySize::Medium),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d M Y, h:i A')
                                    ->size(TextEntry\TextEntrySize::Small),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d M Y, h:i A')
                                    ->size(TextEntry\TextEntrySize::Small),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }
}
