<?php

namespace App\Filament\Resources\StorageRequestResource\Pages;

use App\Filament\Resources\StorageRequestResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;

class ViewStorageRequest extends ViewRecord
{
    protected static string $resource = StorageRequestResource::class;

    public function getInfolist(string $name): ?Infolist
    {
        return Infolist::make()
            ->record($this->record)
            ->schema([
                Section::make('Storage Request Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('user.name')
                                ->label('Requested By')
                                ->icon('heroicon-o-user'),

                            TextEntry::make('user.role.name')
                                ->label('Role')
                                ->icon('heroicon-o-identification'),

                            TextEntry::make('amount_gb')
                                ->label('Amount (GB)')
                                ->suffix(' GB')
                                ->icon('heroicon-o-circle-stack'),

                            TextEntry::make('status')
                                ->label('Status')
                                ->icon('heroicon-o-check-circle')
                                ->badge()
                                ->colors([
                                    'primary' => 'pending',
                                    'success' => 'approved',
                                    'danger' => 'rejected',
                                ]),

                            TextEntry::make('created_at')
                                ->label('Created At')
                                ->icon('heroicon-o-calendar')
                                ->dateTime()
                                ->columnSpan(2),
                        ]),

                        TextEntry::make('reason')
                            ->label('Reason')
                            ->icon('heroicon-o-chat-bubble-left-ellipsis')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }
}
