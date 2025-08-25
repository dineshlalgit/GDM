<x-filament::page>
    <style>
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 32px;
            margin-top: 24px;
        }
        .media-card {
            border-radius: 24px;
            box-shadow: 0 4px 24px #0002;
            padding: 32px 20px 20px 20px;
            width: 260px;
            height: 370px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            margin: 0 auto;
            color: #fff;
            background: #fff; /* fallback */
            overflow: hidden;
            transition: box-shadow 0.2s;
        }
        .media-card:hover {
            box-shadow: 0 8px 32px #0003;
        }
        .media-card-icon {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            margin-top: 18px;
        }
        .media-card-icon-circle {
            width: 110px;
            height: 110px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px #0002;
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .media-card-icon-circle img {
            width: 72px;
            height: 72px;
            object-fit: contain;
            display: block;
        }
        .media-card-preview-img-rect {
            width: 90%;
            height: 120px;
            object-fit: cover;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 2px 8px #0002;
            border: 2px solid #fff;
            display: block;
        }
        .media-card-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
            letter-spacing: 1px;
        }
        .media-card-filename {
            font-size: 1.05rem;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
            word-break: break-all;
            color: #fff;
            text-shadow: 0 1px 4px #0005;
        }
        .media-card-date {
            font-size: 0.9rem;
            margin-bottom: 24px;
            text-align: center;
            opacity: 0.85;
        }
        .media-card-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            position: absolute;
            bottom: 18px;
            left: 0;
            width: 100%;
        }
        .media-card-actions a,
        .media-card-actions button {
            background: #fff;
            color: #10b981;
            border: none;
            border-radius: 6px;
            padding: 6px 18px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 1px 4px #0001;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .media-card-actions button {
            color: #ef4444;
        }
        .media-card-actions a:hover {
            background: #e6f7ef;
        }
        .media-card-actions button:hover {
            background: #ffeaea;
        }
        .gradient-red {
            background: linear-gradient(135deg, #e53935 0%, #fbc02d 100%);
        }
        .gradient-blue {
            background: linear-gradient(135deg, #1976d2 0%, #64b5f6 100%);
        }
        .gradient-green {
            background: linear-gradient(135deg, #43a047 0%, #a5d6a7 100%);
        }
        .gradient-yellow {
            background: linear-gradient(135deg, #fbc02d 0%, #ffb300 100%);
        }
        .gradient-purple {
            background: linear-gradient(135deg, #8e24aa 0%, #ce93d8 100%);
        }
        .gradient-darkgreen {
            background: linear-gradient(135deg, #388e3c 0%, #81c784 100%);
        }
        .gradient-orange {
            background: linear-gradient(135deg, #ff9800 0%, #ffe082 100%);
        }
        .gradient-gray {
            background: linear-gradient(135deg, #bdbdbd 0%, #eeeeee 100%);
        }
        .gradient-brown {
            background: linear-gradient(135deg, #8d6e63 0%, #d7ccc8 100%);
        }
        .fab-new-media {
            position: fixed;
            bottom: 2.5rem;
            right: 2.5rem;
            z-index: 50;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 16px #0002;
        }
        @media (max-width: 640px) {
            .fab-new-media span {
                display: none;
            }
        }
    </style>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Media Gallery</h2>
        <a href="{{ \App\Filament\User\Resources\FileResource::getUrl('create') }}"
           class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded font-semibold shadow transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4" />
            </svg>
            <span>New media file</span>
        </a>
    </div>

    <div class="media-grid">
        @foreach($mediaFiles as $file)
            @php
                // 🎵 AUDIO
                $audioTypes = ['mp3', 'wav', 'ogg', 'm4a', 'mpeg', 'aac', 'flac', 'wma', 'aiff', 'alac', 'mpeg'];

                // 🎬 VIDEO
                $videoTypes = ['mp4', 'mov', 'avi', 'mkv', 'wmv', 'flv', 'webm', '3gp'];

                // 🖼️ IMAGE
                $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'tiff', 'ico', 'heic'];

                // 📄 DOCUMENT
                $documentTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'rtf', 'odt', 'ods', 'odp'];

                // 📦 ARCHIVE
                $archiveTypes = ['zip', 'rar', '7z', 'tar', 'gz'];

                $type = strtolower($file->file_type);
                $isImage = in_array($type, $imageTypes);

                // ICON SELECTION
                $icon = match (true) {
                    in_array($type, $videoTypes)   => asset('storage/media/icons/video.png'),
                    in_array($type, $audioTypes)   => asset('storage/media/icons/audio.webp'),
                    $type === 'pdf'                => asset('storage/media/icons/pdf.png'),
                    in_array($type, ['doc', 'docx']) => asset('storage/media/icons/msdoc.png'),
                    in_array($type, ['xls', 'xlsx']) => asset('storage/media/icons/excel.png'),
                    in_array($type, ['ppt', 'pptx']) => asset('storage/media/icons/ppt.png'),
                    in_array($type, $archiveTypes) => asset('storage/media/icons/archive.png'),
                    default                        => asset('storage/media/icons/file.png'),
                };

                // GRADIENT CLASS SELECTION
                $gradientClass = match (true) {
                    $type === 'pdf'                => 'gradient-red',
                    in_array($type, $videoTypes)   => 'gradient-blue',
                    in_array($type, $audioTypes)   => 'gradient-green',
                    in_array($type, $imageTypes)   => 'gradient-yellow',
                    in_array($type, ['doc', 'docx']) => 'gradient-purple',
                    in_array($type, ['xls', 'xlsx']) => 'gradient-darkgreen',
                    in_array($type, ['ppt', 'pptx']) => 'gradient-orange',
                    in_array($type, $archiveTypes) => 'gradient-brown',
                    default                        => 'gradient-gray',
                };
                $fileName = pathinfo(basename($file->file_path), PATHINFO_FILENAME);
            @endphp
            <div class="media-card {{ $gradientClass }}">
                <div class="media-card-icon">
                    @if($isImage)
                        <img src="{{ Storage::disk('public')->url($file->file_path) }}" alt="File" class="media-card-preview-img-rect" />
                    @else
                        <div class="media-card-icon-circle">
                            <img src="{{ $icon }}" alt="Icon" />
                        </div>
                    @endif
                </div>
                <div class="media-card-title">{{ strtoupper($file->file_type) }}</div>
                <div class="media-card-filename" title="{{ $fileName }}">{{ $fileName }}</div>
                <div class="media-card-date">{{ $file->uploaded_at ? \Carbon\Carbon::parse($file->uploaded_at)->format('M d, Y H:i') : '' }}</div>
                <div class="media-card-actions">
                    <a href="{{ Storage::disk('public')->url($file->file_path) }}" download>Download</a>
                    <form method="POST" action="{{ route('custom.file.delete', $file->id) }}">
                        @csrf
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-filament::page>
