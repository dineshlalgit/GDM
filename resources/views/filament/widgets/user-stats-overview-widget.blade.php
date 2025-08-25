<x-filament::widget>
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
        .stat-bg-1 { background: linear-gradient(135deg, #139968 0%, #66bb8e 100%); }
        .stat-bg-2 { background: linear-gradient(135deg, #8b5cf6 0%, #38bdf8 100%); }
        .stat-bg-3 { background: linear-gradient(135deg, #06b6d4 0%, #2563eb 100%); }
        .stat-bg-4 { background: linear-gradient(135deg, #ec4899 0%, #f87171 100%); }
        .stat-bg-5 { background: linear-gradient(135deg, #64748b 0%, #a1a1aa 100%); }
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
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach ($stats as $i => $stat)
                <div class="custom-stat-card stat-bg-{{ ($i % 5) + 1 }}">
                    <div class="flex flex-col z-10">
                        <div class="custom-stat-label">{{ $stat['label'] }}</div>
                        <div class="custom-stat-number">{{ $stat['count'] }}</div>
                        <div class="custom-stat-desc">{{ $stat['desc'] }}</div>
                    </div>
                    <span class="custom-stat-icon z-10">
                        @if ($stat['icon'] === 'photo')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v9.75A2.25 2.25 0 0118.75 18H5.25A2.25 2.25 0 013 16.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5l5.25-7.5 4.5 6 3-4.5L21 16.5" /></svg>
                        @elseif ($stat['icon'] === 'video-camera')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6.75A2.25 2.25 0 0013.5 4.5h-9A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5h9a2.25 2.25 0 002.25-2.25v-3.75l5.22 3.915A.75.75 0 0022.5 16.5v-9a.75.75 0 00-1.23-.585L15.75 10.5z" /></svg>
                        @elseif ($stat['icon'] === 'musical-note')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5zM9 18.75V6.75A2.25 2.25 0 0111.25 4.5h7.5A2.25 2.25 0 0121 6.75v10.5" /></svg>
                        @elseif ($stat['icon'] === 'document-text')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75v4.5a2.25 2.25 0 002.25 2.25h4.5M6.75 3.75A2.25 2.25 0 004.5 6v12a2.25 2.25 0 002.25 2.25h10.5A2.25 2.25 0 0019.5 18V8.25a.75.75 0 00-.75-.75h-4.5A2.25 2.25 0 0112 5.25V3.75a.75.75 0 00-.75-.75h-4.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 3h6" /></svg>
                        @elseif ($stat['icon'] === 'archive-box')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v1.5M3 7.5h18M3 7.5v10.75A2.25 2.25 0 005.25 20.5h13.5A2.25 2.25 0 0021 18.25V7.5" /></svg>
                        @endif
                    </span>
                    <div class="custom-stat-overlay">
                        <svg width="120" height="120" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="50" fill="#fff" fill-opacity="0.2"/></svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::widget>
