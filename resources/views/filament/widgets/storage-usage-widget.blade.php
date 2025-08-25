<x-filament::widget>
    <style>
        .custom-storage-card {
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            color: #fff;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 120px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            padding: 2rem 2.5rem;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #e8b020 0%, #ead890 100%);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .custom-storage-card:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.22);
        }
        .custom-storage-icon {
            background: rgba(255,255,255,0.18);
            border-radius: 9999px;
            width: 4.5rem;
            height: 4.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .custom-storage-icon svg {
            width: 2.5rem;
            height: 2.5rem;
            stroke: #fff;
        }
        .custom-storage-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
        }
        .custom-storage-label {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: 0.01em;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .custom-storage-amount {
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 0.25rem;
            font-family: 'JetBrains Mono', 'Fira Mono', 'Menlo', monospace;
            text-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .custom-storage-desc {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.92;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 0.5rem;
        }
        .custom-storage-bar-bg {
            width: 100%;
            height: 16px;
            background: rgba(255,255,255,0.18);
            border-radius: 8px;
            margin-top: 0.5rem;
            margin-bottom: 0.25rem;
            overflow: hidden;
        }
        .custom-storage-bar {
            height: 100%;
            border-radius: 8px;
            background: linear-gradient(90deg, #fff 0%, #fbbf24 100%);
            transition: width 0.5s;
        }
        .custom-storage-overlay {
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
        <div class="custom-storage-card">
            <span class="custom-storage-icon">
                <!-- Storage Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v1.5M3 7.5h18M3 7.5v10.75A2.25 2.25 0 005.25 20.5h13.5A2.25 2.25 0 0021 18.25V7.5" /></svg>
            </span>
            <div class="custom-storage-info">
                <div class="custom-storage-label">Storage Usage</div>
                <div class="custom-storage-amount">{{ $used }} <span style="font-size:1.2rem;font-weight:400;opacity:0.8;">/ {{ $total }}</span></div>
                <div class="custom-storage-desc">{{ $percent }}% used — Current used storage out of total available</div>
                <div class="custom-storage-bar-bg">
                    <div class="custom-storage-bar" style="width: {{ $percent }}%;"></div>
                </div>
            </div>
            <div class="custom-storage-overlay">
                <svg width="120" height="120" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="50" fill="#fff" fill-opacity="0.2"/></svg>
            </div>
        </div>
    </div>
</x-filament::widget>
