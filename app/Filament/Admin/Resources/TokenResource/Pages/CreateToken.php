<?php

namespace App\Filament\Admin\Resources\TokenResource\Pages;

use App\Filament\Admin\Resources\TokenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateToken extends CreateRecord
{
    protected static string $resource = TokenResource::class;
}
