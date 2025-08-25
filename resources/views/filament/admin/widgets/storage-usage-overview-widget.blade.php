@php
    $stats = $this->getStats();
@endphp
<x-filament::widget>
    <div class="mb-10 text-center">
        <div class="flex flex-col items-center gap-3">
            <span class="text-4xl">🗄️</span>
            <span class="text-3xl font-extrabold bg-gradient-to-r from-amber-500 to-yellow-400 bg-clip-text text-transparent">Storage Usage Overview</span>
        </div>
        <div class="mt-2 text-base text-gray-500">Total storage, files, and average per user/admin.</div>
    </div>
    <style>
        .custom-stat-card {
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            color: #fff;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 120px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .custom-stat-card:hover {
            transform: scale(1.04);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.22);
        }
        .stat-storage-bg-1 { background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%); }
        .stat-storage-bg-2 { background: linear-gradient(135deg, #f43f5e 0%, #f59e42 100%); }
        .stat-storage-bg-3 { background: linear-gradient(135deg, #f5f22c 0%, #a38016 100%); }
        .custom-stat-label {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: 0.01em;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .custom-stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.25rem;
            font-family: 'JetBrains Mono', 'Fira Mono', 'Menlo', monospace;
            text-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .custom-stat-desc {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.92;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .custom-stat-icon {
            background: rgba(255,255,255,0.18);
            border-radius: 9999px;
            width: 4.5rem;
            height: 4.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .custom-stat-icon svg {
            width: 2.5rem;
            height: 2.5rem;
            stroke: #fff;
        }
        .custom-stat-overlay {
            position: absolute;
            right: -30px;
            bottom: -30px;
            width: 120px;
            height: 120px;
            opacity: 0.12;
            pointer-events: none;
        }
    </style>
    <div class="w-full px-0">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @php
                $meta = [
                    [
                        'label' => 'Total Storage Used',
                        'desc' => 'All user/admin files',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>',
                        'bg' => 'stat-storage-bg-1',
                    ],
                    [
                        'label' => 'Total Files',
                        'desc' => 'All uploaded files',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7"/></svg>',
                        'bg' => 'stat-storage-bg-2',
                    ],
                    [
                        'label' => 'Avg Storage/User',
                        'desc' => 'Average per user/admin',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>',
                        'bg' => 'stat-storage-bg-3',
                    ],
                ];
                $values = [$stats[0]->value, $stats[1]->value, $stats[2]->value];
            @endphp
            @foreach ($meta as $i => $m)
                <div class="custom-stat-card {{ $m['bg'] }}">
                    <div class="flex flex-col z-10">
                        <div class="custom-stat-label">{{ $m['label'] }}</div>
                        <div class="custom-stat-number">{{ $values[$i] }}</div>
                        <div class="custom-stat-desc">{{ $m['desc'] }}</div>
                    </div>
                    <span class="custom-stat-icon z-10">{!! $m['icon'] !!}</span>
                    <div class="custom-stat-overlay">
                        <svg width="120" height="120" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="50" fill="#fff" fill-opacity="0.2"/></svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::widget>
