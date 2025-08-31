<?php

namespace App\Filament\Resources\AccountBalanceResource\Pages;

use App\Filament\Resources\AccountBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditAccountBalance extends EditRecord
{
    protected static string $resource = AccountBalanceResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = Auth::id();

        // Recalculate net change and closing balance
        $data['net_change'] = ($data['total_income'] ?? 0) - ($data['total_expenses'] ?? 0);
        $data['closing_balance'] = ($data['opening_balance'] ?? 0) + $data['net_change'];

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
