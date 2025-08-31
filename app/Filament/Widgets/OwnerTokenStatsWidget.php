<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Token;

class OwnerTokenStatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.owner-token-stats-widget';

    public function getViewData(): array
    {
        $total = Token::count();
        $generated = Token::where('status', 'generated')->count();
        $used = Token::where('status', 'used')->count();
        $totalValue = Token::sum('balance_amount');
        $usedValue = Token::where('status', 'used')->sum('balance_amount');
        $unusedValue = Token::where('status', 'generated')->sum('balance_amount');

        return [
            'stats' => [
                [
                    'label' => 'Total Tokens',
                    'count' => $total,
                    'icon' => 'ticket',
                    'desc' => 'All generated tokens',
                    'color' => 'purple',
                ],
                [
                    'label' => 'Active Tokens',
                    'count' => $generated,
                    'icon' => 'clock',
                    'desc' => 'Available for use',
                    'color' => 'warning',
                ],
                [
                    'label' => 'Used Tokens',
                    'count' => $used,
                    'icon' => 'check-circle',
                    'desc' => 'Redeemed tokens',
                    'color' => 'success',
                ],
                [
                    'label' => 'Total Value',
                    'count' => '₹' . number_format($totalValue, 2),
                    'icon' => 'currency-rupee',
                    'desc' => 'Combined token value',
                    'color' => 'info',
                ],
                [
                    'label' => 'Unused Value',
                    'count' => '₹' . number_format($unusedValue, 2),
                    'icon' => 'banknotes',
                    'desc' => 'Available for redemption',
                    'color' => 'warning',
                ],
                [
                    'label' => 'Redeemed Value',
                    'count' => '₹' . number_format($usedValue, 2),
                    'icon' => 'gift',
                    'desc' => 'Total redeemed amount',
                    'color' => 'success',
                ],
            ],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
