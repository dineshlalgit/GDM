<x-filament::widget>
    <style>
        .stat-top-users-card {
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            color: #fff;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 1.5rem;
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            overflow-x: auto;
        }

        .stat-top-users-label {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: 0.01em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stat-users-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .stat-users-table th, .stat-users-table td {
            padding: 0.6rem 1rem;
            text-align: left;
            vertical-align: middle;
            white-space: nowrap;
        }

        .stat-users-table th {
            font-weight: 700;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .stat-users-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-users-username {
            font-weight: 600;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat-users-storage {
            font-family: 'JetBrains Mono', 'Fira Mono', monospace;
            text-align: right;
        }

        .stat-users-status {
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .status-active {
            color: #bbf7d0;
        }

        .status-inactive {
            color: #fde68a;
        }

        .placeholder {
            color: #ddd;
            font-style: italic;
        }
    </style>

    <div class="stat-top-users-card">
        <div class="stat-top-users-label">
            🏆 Top 5 Users by Storage
        </div>

        <table class="stat-users-table">
            <thead>
                <tr>
                    <th>👤 Username</th>
                    <th class="text-right">💾 Storage</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $topUsers = $this->getTopUsers();
                    $filledSlots = count($topUsers);
                @endphp

                @foreach($topUsers as $user)
                    <tr>
                        <td class="stat-users-username">{{ $user->name }}</td>
                        <td class="stat-users-storage">
                            {{ number_format(($user->used_storage ?? 0) / (1024*1024*1024), 2) }} GB
                        </td>
                        <td class="stat-users-status">
                            @php
                                // The correct field is likely 'active', not 'is_active'
                                $status = $user->active ?? false;
                                $statusLabel = $status ? 'Active' : 'Inactive';
                                $statusClass = $status ? 'status-active' : 'status-inactive';
                            @endphp
                            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                    </tr>
                @endforeach

                @for($i = $filledSlots; $i < 5; $i++)
                    <tr>
                        <td class="stat-users-username placeholder">—</td>
                        <td class="stat-users-storage placeholder">0.00 GB</td>
                        <td class="stat-users-status placeholder">—</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</x-filament::widget>
