<x-filament::widget>
    <div class="mb-10 text-center">
        <div class="flex flex-col items-center gap-3">
            <span class="text-4xl">🗓️</span>
            <span class="text-3xl font-extrabold bg-gradient-to-r from-blue-500 to-green-500 bg-clip-text text-transparent">Leave Request Statistics</span>
        </div>
        <div class="mt-2 text-base text-gray-500">Overview of all leave requests in the system.</div>
    </div>
    <style>
        .custom-leave-stat-card {
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
        .custom-leave-stat-card:hover {
            transform: scale(1.04);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.22);
        }
        .leave-bg-1 { background: linear-gradient(135deg, #6366f1 0%, #38bdf8 100%); }
        .leave-bg-2 { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
        .leave-bg-3 { background: linear-gradient(135deg, #dea71c 0%, #fde68a 100%); }
        .leave-bg-4 { background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); }
        .leave-bg-total { background: linear-gradient(135deg, #f6ca5c 0%, #ceec48 100%); }
        .leave-bg-pending { background: linear-gradient(135deg, #7371f8 0%, #2444fb 100%); }
        .custom-leave-stat-label {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: 0.01em;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .custom-leave-stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.25rem;
            font-family: 'JetBrains Mono', 'Fira Mono', 'Menlo', monospace;
            text-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .custom-leave-stat-desc {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.92;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .custom-leave-stat-icon {
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
        .custom-leave-stat-icon svg {
            width: 2.5rem;
            height: 2.5rem;
            stroke: #fff;
        }
        .custom-leave-stat-overlay {
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
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @php
                $leaveMeta = [
                    [
                        'label' => 'Total Leave Requests',
                        'desc' => 'All leave requests',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 7.5h16.5M4.5 21h15a1.5 1.5 0 001.5-1.5V7.5a1.5 1.5 0 00-1.5-1.5h-15A1.5 1.5 0 003 7.5v12A1.5 1.5 0 004.5 21z" /></svg>',
                        'bg' => 'leave-bg-total',
                    ],
                    [
                        'label' => 'Approved',
                        'desc' => 'Approved requests',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                        'bg' => 'leave-bg-2',
                    ],
                    [
                        'label' => 'Pending',
                        'desc' => 'Pending requests',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" /><circle cx="12" cy="12" r="9" /></svg>',
                        'bg' => 'leave-bg-pending',
                    ],
                    [
                        'label' => 'Rejected',
                        'desc' => 'Rejected requests',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /><circle cx="12" cy="12" r="9" /></svg>',
                        'bg' => 'leave-bg-4',
                    ],
                ];
            @endphp
            @foreach ($stats as $i => $stat)
                <div class="custom-leave-stat-card {{ $leaveMeta[$i]['bg'] }}">
                    <div class="flex flex-col z-10">
                        <div class="custom-leave-stat-label">{{ $leaveMeta[$i]['label'] }}</div>
                        <div class="custom-leave-stat-number">{{ $stat['count'] }}</div>
                        <div class="custom-leave-stat-desc">{{ $leaveMeta[$i]['desc'] }}</div>
                    </div>
                    <span class="custom-leave-stat-icon z-10">{!! $leaveMeta[$i]['icon'] !!}</span>
                    <div class="custom-leave-stat-overlay">
                        <svg width="120" height="120" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="50" fill="#fff" fill-opacity="0.2"/></svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::widget>
