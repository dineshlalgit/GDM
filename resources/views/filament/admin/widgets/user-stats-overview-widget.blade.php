@php
    $stats = $this->getStats();
@endphp
<x-filament::widget>
    <div class="mb-10 text-center">
        <div class="flex flex-col items-center gap-3">
            <span class="text-4xl">👥</span>
            <span class="text-3xl font-extrabold bg-gradient-to-r from-amber-500 to-yellow-400 bg-clip-text text-transparent">User Stats Overview</span>
        </div>
        <div class="mt-2 text-base text-gray-500">Total, active, suspended users, and role breakdown.</div>
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
        .stat-user-bg-1 { background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%); }
        .stat-user-bg-2 { background: linear-gradient(135deg, #2fc83f 0%, #26913f 100%); }
        .stat-user-bg-3 { background: linear-gradient(135deg, #e34040 0%, #d47406 100%); }
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
        .role-breakdown-section {
            margin-top: 2rem;
        }
        .role-breakdown-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem;
            justify-content: center;
        }
        .role-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 1.5rem;
            font-size: 1.1rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            background: #fff;
            color: #222;
            border: 2px solid #fbbf24;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .role-badge.owner {
            border-color: #8b5cf6;
            color: #8b5cf6;
        }
        .role-badge.admin {
            border-color: #f59e42;
            color: #f59e42;
        }
        .role-badge.staff {
            border-color: #3b82f6;
            color: #3b82f6;
        }
        .role-badge.user {
            border-color: #10b981;
            color: #10b981;
        }
        .role-badge .icon {
            font-size: 1.3em;
        }
    </style>
    <div class="w-full px-0">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @php
                $meta = [
                    [
                        'label' => 'Total Users',
                        'desc' => 'All users',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2a4 4 0 10-8 0 4 4 0 008 0zm6 2a4 4 0 00-3-3.87"/></svg>',
                        'bg' => 'stat-user-bg-1',
                    ],
                    [
                        'label' => 'Active Users',
                        'desc' => 'Currently active',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>',
                        'bg' => 'stat-user-bg-2',
                    ],
                    [
                        'label' => 'Suspended Users',
                        'desc' => 'Currently suspended',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>',
                        'bg' => 'stat-user-bg-3',
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
        <div class="role-breakdown-section">
            <div class="text-lg font-semibold mb-2">Role Breakdown</div>
            <ul class="role-breakdown-list">
                @foreach($stats[3]->value as $role)
                    @php
                        $roleClass = strtolower($role['role']);
                        $icon = match($roleClass) {
                            'owner' => '👑',
                            'admin' => '🛡️',
                            'staff' => '👥',
                            'user' => '👤',
                            default => '🔰',
                        };
                    @endphp
                    <li class="role-badge {{ $roleClass }}">
                        <span class="icon">{{ $icon }}</span>
                        {{ ucfirst($role['role']) }}: {{ $role['count'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-filament::widget>
