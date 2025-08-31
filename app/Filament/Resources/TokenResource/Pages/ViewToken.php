<?php

namespace App\Filament\Resources\TokenResource\Pages;

use App\Filament\Resources\TokenResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;

class ViewToken extends ViewRecord
{
    protected static string $resource = TokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No edit/delete actions for owner panel - tokens are read-only
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Token Information')
                    ->description('Complete details of the token')
                    ->icon('heroicon-o-ticket')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('token_code')
                                    ->label('Token Code')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold')
                                    ->copyable()
                                    ->copyMessage('Token code copied!')
                                    ->copyMessageDuration(1500),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'generated' => 'warning',
                                        'used' => 'success',
                                        default => 'gray',
                                    }),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('customer_name')
                                    ->label('Customer Name')
                                    ->size(TextEntry\TextEntrySize::Medium),
                                TextEntry::make('contact_number')
                                    ->label('Contact Number')
                                    ->size(TextEntry\TextEntrySize::Medium),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('balance_amount')
                                    ->label('Balance Amount')
                                    ->money('INR')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),
                                TextEntry::make('created_at')
                                    ->label('Generated Date')
                                    ->dateTime('d M Y, h:i A')
                                    ->size(TextEntry\TextEntrySize::Medium),
                            ]),
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('d M Y, h:i A')
                            ->size(TextEntry\TextEntrySize::Medium),
                    ])
                    ->columns(1),
            ]);
    }
}
