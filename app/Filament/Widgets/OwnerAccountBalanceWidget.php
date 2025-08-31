<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\AccountBalance;
use Carbon\Carbon;

class OwnerAccountBalanceWidget extends Widget
{
    protected static string $view = 'filament.widgets.owner-account-balance-widget';

    public function getViewData(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Get today's balance
        $todayBalance = AccountBalance::whereDate('date', $today)->first();

        // Get yesterday's balance (for opening balance reference)
        $yesterdayBalance = AccountBalance::whereDate('date', $yesterday)->first();

        // Get latest balance
        $latestBalance = AccountBalance::latest()->first();

        // Calculate total current balance (latest closing balance)
        $totalCurrentBalance = $latestBalance ? $latestBalance->closing_balance : 0;

        // Get today's financial summary
        $todayIncome = $todayBalance ? $todayBalance->total_income : 0;
        $todayExpenses = $todayBalance ? $todayBalance->total_expenses : 0;
        $todayNetChange = $todayBalance ? $todayBalance->net_change : 0;

        // Get monthly summary
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        $monthlyIncome = AccountBalance::whereBetween('date', [$monthStart, $monthEnd])
            ->sum('total_income');
        $monthlyExpenses = AccountBalance::whereBetween('date', [$monthStart, $monthEnd])
            ->sum('total_expenses');
        $monthlyNetChange = $monthlyIncome - $monthlyExpenses;

        return [
            'todayBalance' => $todayBalance,
            'yesterdayBalance' => $yesterdayBalance,
            'totalCurrentBalance' => $totalCurrentBalance,
            'todayIncome' => $todayIncome,
            'todayExpenses' => $todayExpenses,
            'todayNetChange' => $todayNetChange,
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpenses' => $monthlyExpenses,
            'monthlyNetChange' => $monthlyNetChange,
            'hasTodayEntry' => $todayBalance !== null,
            'suggestedOpeningBalance' => $yesterdayBalance ? $yesterdayBalance->closing_balance : 0,
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
