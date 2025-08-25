<x-filament::widget>
    <style>
        .custom-stat-card {
            @apply relative flex flex-col justify-between min-h-[140px] rounded-2xl p-6 overflow-hidden shadow-md transition-transform duration-200 hover:scale-[1.02];
            color: #fff;
        }
        .stat-green {
            background: linear-gradient(135deg, #4ade80 0%, #059669 100%); /* green */
        }
        .stat-orange {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e42 100%); /* orange */
        }
        .stat-blue {
            background: linear-gradient(135deg, #38bdf8 0%, #6366f1 100%); /* blue */
        }
        .stat-red {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%); /* red */
        }
        .stat-teal {
            background: linear-gradient(135deg, #2dd4bf 0%, #0e7490 100%); /* teal */
        }
        .stat-gray {
            background: linear-gradient(135deg, #a1a1aa 0%, #52525b 100%); /* gray */
        }
        .custom-stat-label {
            @apply text-lg font-semibold mb-1;
        }
        .custom-stat-number {
            @apply text-4xl font-bold mb-2;
        }
        .custom-stat-desc {
            @apply text-sm opacity-80;
        }
        .custom-stat-icon {
            @apply absolute top-4 right-4 w-12 h-12 opacity-30;
        }
        .custom-stat-overlay {
            @apply absolute -bottom-8 -right-8 z-0;
        }
    </style>
    <div class="mb-10 text-center">
        <div class="flex flex-col items-center gap-3">
            <span class="text-4xl">📁</span>
            <span class="text-3xl font-extrabold bg-gradient-to-r from-green-400 to-blue-500 bg-clip-text text-transparent">File Type Statistics</span>
        </div>
        <div class="mt-2 text-base text-gray-500">Overview of all uploaded file types.</div>
    </div>
    <div class="w-full px-0">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($stats as $i => $stat)
                @php
                    $colorClasses = [
                        'stat-green',   // Total Files
                        'stat-orange',  // Total Images
                        'stat-blue',    // Total Videos
                        'stat-red',     // Total Audios
                        'stat-teal',    // Total Documents
                        'stat-gray',    // Other Files
                    ];
                @endphp
                <div class="custom-stat-card {{ $colorClasses[$i % count($colorClasses)] }}">
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
