<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EventAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'file_path',
        'mime_type',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::deleting(function (EventAttachment $attachment): void {
            if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
                Log::info('[EventAttachment] File deleted from storage.', [
                    'path' => $attachment->file_path,
                ]);
            } else {
                Log::warning('[EventAttachment] File not found during delete.', [
                    'path' => $attachment->file_path,
                ]);
            }
        });
    }
}


