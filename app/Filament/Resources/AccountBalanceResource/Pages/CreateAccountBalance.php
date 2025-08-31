<?php

namespace App\Filament\Resources\AccountBalanceResource\Pages;

use App\Filament\Resources\AccountBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAccountBalance extends CreateRecord
{
    protected static string $resource = AccountBalanceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['updated_by'] = Auth::id();

        // Calculate net change and closing balance
        $data['net_change'] = ($data['total_income'] ?? 0) - ($data['total_expenses'] ?? 0);
        $data['closing_balance'] = ($data['opening_balance'] ?? 0) + $data['net_change'];

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
