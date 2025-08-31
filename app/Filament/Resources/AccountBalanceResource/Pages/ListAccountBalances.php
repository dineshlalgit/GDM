<?php

namespace App\Filament\Resources\AccountBalanceResource\Pages;

use App\Filament\Resources\AccountBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountBalances extends ListRecords
{
    protected static string $resource = AccountBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Today\'s Balance')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
