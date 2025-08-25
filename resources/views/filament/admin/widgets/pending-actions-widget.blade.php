<x-filament::widget>
    <style>
        .pending-actions-card {
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%);
            color: #fff;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }
        .pending-header {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .pending-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }
        .pending-table th, .pending-table td {
            padding: 0.6rem 1rem;
            text-align: left;
            vertical-align: middle;
            white-space: nowrap;
        }
        .pending-table th {
            font-weight: 700;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
        .pending-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .pending-username {
            font-weight: 600;
        }
        .pending-type {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            background: rgba(255,255,255,0.12);
            margin-right: 0.5rem;
        }
        .pending-status {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
        }
        .status-pending {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffe082;
        }
    </style>
    <div class="pending-actions-card">
        <div class="pending-header">
            ⏳ Pending Actions
        </div>
        <table class="pending-table">
            <thead>
                <tr>
                    <th>🙍 User</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Requested At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->getPendingStorageRequests() as $req)
                    <tr>
                        <td class="pending-username">{{ $req->user->name ?? '—' }}</td>
                        <td><span class="pending-type">Storage</span></td>
                        <td><span class="pending-status status-pending">Pending</span></td>
                        <td>{{ $req->created_at ? \Carbon\Carbon::parse($req->created_at)->format('M d, Y · H:i') : '—' }}</td>
                    </tr>
                @endforeach
                @foreach($this->getPendingLeaveRequests() as $req)
                    <tr>
                        <td class="pending-username">{{ $req->user->name ?? '—' }}</td>
                        <td><span class="pending-type">Leave</span></td>
                        <td><span class="pending-status status-pending">Pending</span></td>
                        <td>{{ $req->created_at ? \Carbon\Carbon::parse($req->created_at)->format('M d, Y · H:i') : '—' }}</td>
                    </tr>
                @endforeach
                @if(count($this->getPendingStorageRequests()) === 0 && count($this->getPendingLeaveRequests()) === 0)
                    <tr>
                        <td colspan="4" class="italic text-gray-500 dark:text-gray-300">No pending actions found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</x-filament::widget>
