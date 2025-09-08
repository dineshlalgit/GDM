<?php

namespace App\Filament\Admin\Resources\EventResource\Pages;

use App\Filament\Admin\Resources\EventResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        $currentRecord = $this->getRecord();
        return $infolist
            ->schema([
                Section::make('Event')
                    ->schema([
                        TextEntry::make('name')->label('Event Name')->weight('bold'),
                        TextEntry::make('event_datetime')->label('Date & Time')->dateTime('M d, Y g:i A'),
                        TextEntry::make('location')->label('Location'),
                        TextEntry::make('status')->label('Status')->badge(),
                    ])->columns(2),

                // Section::make('Attachments')
                //     ->schema([
                //         ViewEntry::make('attachments_gallery')
                //             ->view('filament.admin.event-attachments')
                //             ->viewData([
                //                 'attachments' => $currentRecord->attachments()->latest()->get(),
                //             ])
                //             ->columnSpanFull(),
                //     ]),
            ]);
    }
}


