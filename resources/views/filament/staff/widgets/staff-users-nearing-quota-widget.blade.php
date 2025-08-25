<x-filament::widget>
    <style>
        .quota-warning-card {
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #1fd8c9 0%, #b996f5 100%);
            color: #fff;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }

        .quota-header {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quota-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .quota-table th, .quota-table td {
            padding: 0.6rem 1rem;
            text-align: left;
            vertical-align: middle;
            white-space: nowrap;
        }

        .quota-table th {
            font-weight: 700;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .quota-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .quota-username {
            font-weight: 600;
        }

        .quota-usage {
            font-family: 'JetBrains Mono', 'Fira Mono', monospace;
            text-align: right;
        }

        .quota-status {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
        }

        .status-warning {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffe082;
        }

        .status-danger {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ff8a80;
        }

        .progress-container {
            background-color: rgba(255, 255, 255, 0.15);
            height: 8px;
            border-radius: 4px;
            margin-top: 4px;
            width: 100%;
        }

        .progress-bar {
            height: 100%;
            border-radius: 4px;
            background-color: #fff;
        }

        .usage-details {
            font-size: 0.75rem;
            color: #fefce8;
            margin-top: 2px;
        }
    </style>

    <div class="quota-warning-card">
        <div class="quota-header">
            ⚠️ Users Nearing Quota
        </div>

        <table class="quota-table">
            <thead>
                <tr>
                    <th>👤 Username</th>
                    <th>📊 Usage</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->getUsersNearingQuota() as $user)
                    @php
                        $percentUsed = round(($user->used_storage / $user->quota) * 100, 1);
                        $statusClass = $percentUsed >= 90 ? 'status-danger' : 'status-warning';
                        $statusLabel = $percentUsed >= 90 ? 'Critical' : 'Warning';

                        $usedMB = number_format($user->used_storage, 0);
                        $quotaMB = number_format($user->quota, 0);
                        $barWidth = min($percentUsed, 100);
                    @endphp
                    <tr>
                        <td class="quota-username">{{ $user->name }}</td>
                        <td class="quota-usage" style="width: 260px;">
                            {{ $percentUsed }}%
                            <div class="progress-container">
                                <div class="progress-bar" style="width: {{ $barWidth }}%;"></div>
                            </div>
                            <div class="usage-details">
                                {{ $usedMB }} MB of {{ $quotaMB }} MB
                            </div>
                        </td>
                        <td><span class="quota-status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="italic text-gray-500 dark:text-gray-300">No users nearing quota.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</x-filament::widget>
