<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MediaFile extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_type',
        'uploaded_at',
    ];

    /**
     * Get the user that owns the media file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
{
    static::creating(function ($mediaFile) {
        if (!$mediaFile->uploaded_at) {
            $mediaFile->uploaded_at = now();
        }
    });

    static::deleting(function ($mediaFile) {
        if ($mediaFile->file_path && Storage::disk('public')->exists($mediaFile->file_path)) {
            Storage::disk('public')->delete($mediaFile->file_path);

            Log::info('[MediaFile] File deleted from storage.', [
                'path' => $mediaFile->file_path,
            ]);
        } else {
            Log::warning('[MediaFile] File not found during delete.', [
                'path' => $mediaFile->file_path,
            ]);
        }
    });
}


    // ❌ Removed MIME detection from the attribute setter
    public function setFilePathAttribute($value)
    {
        $this->attributes['file_path'] = $value;
    }
}
