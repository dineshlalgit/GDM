<x-filament::widget>
    <style>
        .custom-table-card {
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%);
            color: #fff;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }
        .custom-table th, .custom-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            vertical-align: middle;
            white-space: nowrap;
        }
        .custom-table th {
            font-weight: 700;
            border-bottom: 2px solid rgba(255, 255, 255, 0.18);
        }
        .custom-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .truncate-cell {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .table-header {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
    <div class="custom-table-card">
        <div class="table-header">
            📨 Recent Storage Requests
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>🙍 User</th>
                    <th>Role</th>
                    <th>Amount (GB)</th>
                    <th>Status</th>
                    <th>Requested At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->getRecentRequests() as $req)
                    <tr>
                        <td class="truncate-cell">{{ $req->user->name ?? '—' }}</td>
                        <td>{{ $req->user->role->name ?? '—' }}</td>
                        <td>{{ $req->amount_gb }}</td>
                        <td>{{ ucfirst($req->status) }}</td>
                        <td>{{ $req->created_at ? \Carbon\Carbon::parse($req->created_at)->format('M d, Y · H:i') : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center italic text-gray-200">No recent storage requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament::widget>
