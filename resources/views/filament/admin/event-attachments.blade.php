<style>
    .grid-attachments{display:grid;grid-template-columns:repeat(12,minmax(0,1fr));gap:18px}
    .file-card{grid-column:span 12 / span 12;background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 2px 8px rgba(15,23,42,.06);overflow:hidden}
    @media (min-width:768px){.file-card{grid-column:span 6 / span 6}}@media (min-width:1024px){.file-card{grid-column:span 4 / span 4}}

    .thumb{position:relative;background:#f8fafc;display:flex;align-items:center;justify-content:center;height:190px}
    .thumb img{width:100%;height:100%;object-fit:cover}
    .badge{position:absolute;top:10px;right:10px;background:#eef2ff;color:#1e293b;border-radius:9999px;padding:4px 8px;font-size:11px;font-weight:600}
    .file-body{padding:12px}
    .file-row{display:flex;align-items:center;justify-content:space-between;gap:10px}
    .file-title{font-size:14px;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .meta{font-size:12px;color:#64748b;display:flex;gap:10px;margin-top:6px}
    .actions{display:flex;gap:8px}
    .icon-btn{appearance:none;border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:7px;display:inline-flex;align-items:center;justify-content:center}
    .icon-btn:hover{background:#f8fafc;border-color:#cbd5e1}
    .modal{position:fixed;inset:0;background:rgba(2,6,23,.6);display:flex;align-items:center;justify-content:center;padding:16px;z-index:50}
    .modal-card{background:#fff;border-radius:16px;box-shadow:0 14px 30px rgba(15,23,42,.28);width:100%;max-width:1100px}
    .modal-head{display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #eef2f7;padding:10px 14px}
    .modal-body{padding:12px}
    .iframe{width:100%;height:78vh;border:0}
</style>

<div class="space-y-4">
    @if($attachments->isEmpty())
        <div class="text-sm text-gray-500">You haven't uploaded any attachments yet.</div>
    @endif

    <div class="grid-attachments">
        @foreach($attachments as $att)
            @php
                $mime = $att->mime_type ?? 'application/octet-stream';
                $url = Storage::disk('public')->url($att->file_path);
                $isImage = str_starts_with($mime, 'image/');
                $isVideo = str_starts_with($mime, 'video/');
                $isAudio = str_starts_with($mime, 'audio/');
                $isPdf = $mime === 'application/pdf';
                $name = basename($att->file_path);
                $bytes = Storage::disk('public')->exists($att->file_path) ? Storage::disk('public')->size($att->file_path) : null;
                $size = is_null($bytes) ? '-' : ( $bytes > 1024*1024 ? round($bytes/1024/1024,2).' MB' : round($bytes/1024,2).' KB');
                $age = optional(\Carbon\Carbon::parse($att->uploaded_at))->diffForHumans();
            @endphp

            <div x-data="{ open: false }" class="file-card">
                <div class="thumb">
                    @if($isImage)
                        <img src="{{ $url }}" alt="{{ $name }}" loading="lazy">
                    @else
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="#94a3b8" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" opacity=".2"/><path d="M14 2v6h6M8 13h8M8 17h8M8 9h4" fill="none" stroke="#64748b" stroke-width="1.5" stroke-linecap="round"/></svg>
                    @endif
                    <span class="badge">{{ $isImage ? pathinfo($name, PATHINFO_EXTENSION) : ($isPdf ? 'pdf' : ($isVideo ? 'video' : ($isAudio ? 'audio' : 'file'))) }}</span>
                </div>
                <div class="file-body">
                    <div class="file-row">
                        <div class="file-title" title="{{ $name }}">{{ $name }}</div>
                        <div class="actions">
                            <a class="icon-btn" href="{{ $url }}" download title="Download">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#0f172a" stroke-width="1.8"><path d="M12 3v12m0 0 4-4m-4 4-4-4" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 21h14" stroke-linecap="round"/></svg>
                            </a>
                            @if($isImage || $isVideo || $isAudio || $isPdf)
                                <button type="button" class="icon-btn" title="Expand preview" @click="open = true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#0f172a" stroke-width="1.8">
                                        <path d="M3 9V3h6" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 3l8 8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 15v6h-6" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 21l-8-8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            @endif
                            <a class="icon-btn" href="{{ $url }}" target="_blank" title="Open in new tab">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#0f172a" stroke-width="1.8"><path d="M7 7h10v10M17 7l-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="meta">
                        <span>{{ $size }}</span>
                        <span>{{ $age }}</span>
                    </div>
                </div>

                <template x-if="open">
                    <div class="modal" @click.self="open = false">
                        <div class="modal-card">
                            <div class="modal-head">
                                <div class="file-title" style="font-weight:500">{{ $name }}</div>
                                <button type="button" class="icon-btn" @click="open = false">Close</button>
                            </div>
                            <div class="modal-body">
                                @if($isImage)
                                    <img src="{{ $url }}" alt="{{ $name }}" style="width:100%;max-height:78vh;object-fit:contain;border-radius:10px">
                                @elseif($isVideo)
                                    <video controls playsinline preload="metadata" style="width:100%;max-height:78vh;border-radius:10px">
                                        <source src="{{ $url }}" />
                                    </video>
                                @elseif($isAudio)
                                    <audio controls style="width:100%">
                                        <source src="{{ $url }}" type="{{ $mime }}"/>
                                    </audio>
                                @elseif($isPdf)
                                    <iframe src="{{ $url }}" class="iframe" title="PDF preview"></iframe>
                                @else
                                    <a href="{{ $url }}" target="_blank" class="icon-btn">Open file</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        @endforeach
    </div>
</div>


