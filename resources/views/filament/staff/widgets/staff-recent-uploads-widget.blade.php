<x-filament::widget>
    <style>
        .custom-table-card {
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            background: linear-gradient(135deg, #0ea5e9 0%, #22d3ee 100%);
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

        .filename-cell:hover {
            text-decoration: underline;
            cursor: pointer;
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
            🕑 Recent Uploads
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>📁 File Name</th>
                    <th>👤 User</th>
                    <th>📅 Uploaded At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->getRecentUploads() as $file)
                    <tr>
                        <td class="truncate-cell filename-cell" title="{{ basename($file->file_path) }}">
                            {{ basename($file->file_path) }}
                        </td>
                        <td>{{ $file->user->name ?? '—' }}</td>
                        <td>
                            {{ $file->uploaded_at ? \Carbon\Carbon::parse($file->uploaded_at)->format('M d, Y · H:i') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center italic text-gray-200">No recent uploads found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament::widget>
