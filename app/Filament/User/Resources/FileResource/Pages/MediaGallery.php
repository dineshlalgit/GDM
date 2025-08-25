<?php

namespace App\Filament\User\Resources\FileResource\Pages;

use Filament\Resources\Pages\Page;
use App\Models\MediaFile;
use Illuminate\Support\Facades\Auth;

class MediaGallery extends Page
{
    protected static string $resource = \App\Filament\User\Resources\FileResource::class;
    protected static string $view = 'filament.user.pages.media-gallery';
    public $mediaFiles = [];

    public function mount()
    {
        $this->mediaFiles = MediaFile::where('user_id', Auth::id())->latest()->get();
    }
}
