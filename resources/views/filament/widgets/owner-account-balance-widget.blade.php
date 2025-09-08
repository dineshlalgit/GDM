@php
    $data = $this->getViewData();
@endphp

<x-filament::widget>
    <div class="mb-8 text-center">
        <div class="flex flex-col items-center gap-3">
            <span class="text-4xl">💰</span>
            <span class="text-3xl font-extrabold bg-gradient-to-r from-green-500 to-emerald-500 bg-clip-text text-transparent">Account Balance Overview</span>
        </div>
        <div class="mt-2 text-base text-gray-500">Current financial status and daily balance tracking.</div>
    </div>

    <style>
        .balance-stat-card {
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            color: #fff;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .balance-stat-card:hover {
            transform: scale(1.04);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.22);
        }
        .balance-stat-bg-primary { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .balance-stat-bg-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .balance-stat-bg-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .balance-stat-bg-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .balance-stat-bg-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }

        .balance-stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .balance-stat-icon {
            width: 3rem;
            height: 3rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .balance-stat-label {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: 0.01em;
            text-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .balance-stat-number {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .balance-stat-desc {
            font-size: 0.875rem;
            opacity: 0.9;
            line-height: 1.4;
        }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Current Balance -->
        <div class="balance-stat-card balance-stat-bg-primary">
            <div class="balance-stat-header">
                <div class="balance-stat-icon">🏦</div>
            </div>
            <div class="balance-stat-content">
                <div class="balance-stat-label">Total Current Balance</div>
                <div class="balance-stat-number">₹{{ number_format($data['totalCurrentBalance'], 2) }}</div>
                <div class="balance-stat-desc">Latest closing balance</div>
            </div>
        </div>

        <!-- Today's Balance Status -->
        @if($data['hasTodayEntry'])
            <div class="balance-stat-card balance-stat-bg-success">
                <div class="balance-stat-header">
                    <div class="balance-stat-icon">✅</div>
                </div>
                <div class="balance-stat-content">
                    <div class="balance-stat-label">Today's Balance</div>
                    <div class="balance-stat-number">₹{{ number_format($data['todayBalance']->closing_balance, 2) }}</div>
                    <div class="balance-stat-desc">Updated for today</div>
                </div>
            </div>
        @else
            <div class="balance-stat-card balance-stat-bg-warning">
                <div class="balance-stat-header">
                    <div class="balance-stat-icon">⚠️</div>
                </div>
                <div class="balance-stat-content">
                    <div class="balance-stat-label">Today's Balance</div>
                    <div class="balance-stat-number">Not Updated</div>
                    <div class="balance-stat-desc">Please add today's balance</div>
                </div>
            </div>
        @endif

        <!-- Today's Net Change -->
        <div class="balance-stat-card {{ $data['todayNetChange'] >= 0 ? 'balance-stat-bg-success' : 'balance-stat-bg-danger' }}">
            <div class="balance-stat-header">
                <div class="balance-stat-icon">{{ $data['todayNetChange'] >= 0 ? '📈' : '📉' }}</div>
            </div>
            <div class="balance-stat-content">
                <div class="balance-stat-label">Today's Net Change</div>
                <div class="balance-stat-number">₹{{ number_format($data['todayNetChange'], 2) }}</div>
                <div class="balance-stat-desc">{{ $data['todayNetChange'] >= 0 ? 'Positive' : 'Negative' }} change</div>
            </div>
        </div>

        <!-- Today's Income -->
        <div class="balance-stat-card balance-stat-bg-success">
            <div class="balance-stat-header">
                <div class="balance-stat-icon">💵</div>
            </div>
            <div class="balance-stat-content">
                <div class="balance-stat-label">Today's Income</div>
                <div class="balance-stat-number">₹{{ number_format($data['todayIncome'], 2) }}</div>
                <div class="balance-stat-desc">Total income today</div>
            </div>
        </div>

        <!-- Today's Expenses -->
        <div class="balance-stat-card balance-stat-bg-danger">
            <div class="balance-stat-header">
                <div class="balance-stat-icon">💸</div>
            </div>
            <div class="balance-stat-content">
                <div class="balance-stat-label">Today's Expenses</div>
                <div class="balance-stat-number">₹{{ number_format($data['todayExpenses'], 2) }}</div>
                <div class="balance-stat-desc">Total expenses today</div>
            </div>
        </div>

        <!-- Monthly Summary -->
        <div class="balance-stat-card balance-stat-bg-info">
            <div class="balance-stat-header">
                <div class="balance-stat-icon">📊</div>
            </div>
            <div class="balance-stat-content">
                <div class="balance-stat-label">This Month</div>
                <div class="balance-stat-number">₹{{ number_format($data['monthlyNetChange'], 2) }}</div>
                <div class="balance-stat-desc">Net change this month</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if(!$data['hasTodayEntry'])
                <a href="{{ route('filament.owner.resources.account-balances.create') }}"
                   class="flex items-center p-4 bg-gray-50 border border-gray-200 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg transition-all duration-200 transform hover:scale-105">
                    <span class="text-2xl mr-3">➕</span>
                    <div>
                        <div class="font-semibold">Add Today's Balance</div>
                        <div class="text-sm opacity-90">Update today's financial status</div>
                    </div>
                </a>
            @else
                <a href="{{ route('filament.owner.resources.account-balances.edit', $data['todayBalance']->id) }}"
                   class="flex items-center p-4 bg-gray-50 border border-gray-200 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg transition-all duration-200 transform hover:scale-105">
                    <span class="text-2xl mr-3">✏️</span>
                    <div>
                        <div class="font-semibold">Edit Today's Balance</div>
                        <div class="text-sm opacity-90">Modify today's financial details</div>
                    </div>
                </a>
            @endif

            <a href="{{ route('filament.owner.resources.account-balances.index') }}"
               class="flex items-center p-4 bg-gray-50 border border-gray-200 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg transition-all duration-200 transform hover:scale-105">
                <span class="text-2xl mr-3">📋</span>
                <div>
                    <div class="font-semibold">View All Balances</div>
                    <div class="text-sm opacity-90">Browse complete balance history</div>
                </div>
            </a>
        </div>
    </div>

    @if(!$data['hasTodayEntry'])
        <!-- Suggestion Box -->
        <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <span class="text-2xl">💡</span>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Suggestion</h4>
                    <div class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>Today's balance hasn't been updated yet. Suggested opening balance: <strong>₹{{ number_format($data['suggestedOpeningBalance'], 2) }}</strong></p>
                        <p class="mt-1">Click "Add Today's Balance" to get started.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-filament::widget>
