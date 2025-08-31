@php
    $stats = $this->getViewData()['stats'];
@endphp

<x-filament::widget>
    <div class="mb-8 text-center">
        <div class="flex flex-col items-center gap-3">
            <span class="text-4xl">🎫</span>
            <span class="text-3xl font-extrabold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">Token Statistics</span>
        </div>
        <div class="mt-2 text-base text-gray-500">Overview of all token activities and values.</div>
    </div>

    <style>
        .token-stat-card {
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
        .token-stat-card:hover {
            transform: scale(1.04);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.22);
        }
        .token-stat-bg-purple { background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%); }
        .token-stat-bg-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .token-stat-bg-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .token-stat-bg-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }

        .token-stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .token-stat-icon {
            width: 3rem;
            height: 3rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .token-stat-label {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: 0.01em;
            text-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .token-stat-number {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .token-stat-desc {
            font-size: 0.875rem;
            opacity: 0.9;
            line-height: 1.4;
        }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($stats as $stat)
            <div class="token-stat-card token-stat-bg-{{ $stat['color'] }}">
                <div class="token-stat-header">
                    <div class="token-stat-icon">
                        @switch($stat['icon'])
                            @case('ticket')
                                🎫
                                @break
                            @case('clock')
                                ⏰
                                @break
                            @case('check-circle')
                                ✅
                                @break
                            @case('currency-rupee')
                                💰
                                @break
                            @case('banknotes')
                                💵
                                @break
                            @case('gift')
                                🎁
                                @break
                            @default
                                📊
                        @endswitch
                    </div>
                </div>

                <div class="token-stat-content">
                    <div class="token-stat-label">{{ $stat['label'] }}</div>
                    <div class="token-stat-number">{{ $stat['count'] }}</div>
                    <div class="token-stat-desc">{{ $stat['desc'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('filament.owner.resources.tokens.index') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-lg shadow-lg hover:from-purple-600 hover:to-pink-600 transform hover:scale-105 transition-all duration-200">
            <span class="mr-2">📋</span>
            View All Tokens
        </a>
    </div>
</x-filament::widget>
