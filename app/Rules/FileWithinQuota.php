<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\MediaFile;

class FileWithinQuota implements Rule
{
    public function passes($attribute, $value): bool
    {
        $user = Auth::user();

        if (!$user || !$value) {
            return false;
        }

        $defaultQuota = 5 * 1024 * 1024 * 1024; // 5 GB
        $quota = $user->quota ?? $defaultQuota;

        $used = MediaFile::where('user_id', $user->id)
            ->get()
            ->sum(function ($file) {
                return Storage::disk('public')->exists($file->file_path)
                    ? Storage::disk('public')->size($file->file_path)
                    : 0;
            });

        $newFileSize = $value->getSize();

        return ($used + $newFileSize) <= $quota;
    }

    public function message(): string
    {
        return 'Uploading this file would exceed your storage quota.';
    }
}
