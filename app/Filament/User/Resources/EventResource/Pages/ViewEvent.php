<?php

namespace App\Filament\User\Resources\EventResource\Pages;

use App\Filament\User\Resources\EventResource;
use App\Models\EventRegistration;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use App\Models\EventAttachment;
use Illuminate\Support\Facades\File;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        $record = $this->getRecord();

        $actions = [];

        if ($record->status === 'open' && !$record->isUserRegistered(Auth::id())) {
            $actions[] = Action::make('register')
                ->label('Register for Event')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->action(function () use ($record) {
                    EventRegistration::create([
                        'user_id' => Auth::id(),
                        'event_id' => $record->id,
                        'registered_at' => now(),
                        'status' => 'registered',
                    ]);

                    Notification::make()
                        ->title('Registration Successful')
                        ->body('You have been successfully registered for the event!')
                        ->success()
                        ->send();

                    return redirect()->route('filament.user.resources.events.index');
                })
                ->requiresConfirmation()
                ->modalHeading('Confirm Registration')
                ->modalDescription("Are you sure you want to register for '{$record->name}'?")
                ->modalSubmitActionLabel('Yes, Register');
        }

        $actions[] = Action::make('uploadAttachments')
            ->label('Upload Photos / Videos')
            ->icon('heroicon-o-photo')
            ->color('primary')
            ->form([
                FileUpload::make('files')
                    ->label('Select files')
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->maxSize(512000)
                    ->disk('public')
                    ->directory('event-attachments')
                    ->preserveFilenames()
                    ->acceptedFileTypes([
                        'image/jpeg','image/png','image/webp','image/gif','image/heic','image/heif',
                        'video/mp4','video/quicktime','video/mov','video/webm','video/x-msvideo','video/x-ms-wmv',
                        'audio/mpeg','audio/mp3','audio/mp4','audio/x-m4a','audio/aac','audio/wav','audio/ogg','audio/flac',
                        'application/pdf',
                    ])
                    ->helperText('Images, Videos, Audio, and PDF up to ~500MB total'),
            ])
            ->action(function (array $data) use ($record) {
                $files = $data['files'] ?? [];
                foreach ($files as $path) {
                    $fullPath = is_string($path) ? $path : ($path['path'] ?? null);
                    if (!$fullPath) continue;
                    EventAttachment::create([
                        'event_id' => $record->id,
                        'user_id' => Auth::id(),
                        'file_path' => $fullPath,
                        'mime_type' => (function () use ($fullPath) {
                            $absolute = Storage::disk('public')->path($fullPath);
                            return File::exists($absolute) ? File::mimeType($absolute) : null;
                        })(),
                        'uploaded_at' => now(),
                    ]);
                }

                Notification::make()
                    ->title('Files uploaded')
                    ->body('Your attachments were uploaded successfully.')
                    ->success()
                    ->send();
            })
            ->visible(function () use ($record) {
                if (!Auth::check() || $record->status !== 'open') return false;
                $reg = $record->registrations()->where('user_id', Auth::id())->latest()->first();
                return $reg && ($reg->status === 'accepted');
            });

        return $actions;
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $currentRecord = $this->getRecord();

        return $infolist
            ->schema([
                Section::make('Event Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Event Name')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        TextEntry::make('type')
                            ->label('Event Type')
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'meeting' => 'primary',
                                'workshop' => 'success',
                                'training' => 'info',
                                'celebration' => 'warning',
                                'seminar' => 'danger',
                                'conference' => 'purple',
                                'other' => 'gray',
                                default => 'gray',
                            }),

                        TextEntry::make('description')
                            ->label('Description')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('event_datetime')
                            ->label('Date & Time')
                            ->dateTime('M d, Y g:i A'),

                        TextEntry::make('location')
                            ->label('Location'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'open' => 'success',
                                'closed' => 'gray',
                                default => 'gray',
                            }),

                        TextEntry::make('registration_count')
                            ->label('Total Registrations')
                            ->state(fn ($record) => $record->registrations()->count()),
                    ])
                    ->columns(2),

                Section::make('Registration Status')
                    ->schema([
                        TextEntry::make('registration_status')
                            ->label('Your Status')
                            ->state(function ($record) {
                                $reg = $record->registrations()->where('user_id', Auth::id())->latest()->first();
                                if (!$reg) return 'Not Registered';
                                return ucfirst($reg->status ?? 'pending');
                            })
                            ->badge()
                            ->color(function ($record) {
                                $reg = $record->registrations()->where('user_id', Auth::id())->latest()->first();
                                if (!$reg) return 'gray';
                                return match ($reg->status) {
                                    'accepted' => 'success',
                                    'pending' => 'warning',
                                    'rejected' => 'danger',
                                    default => 'gray',
                                };
                            }),

                        TextEntry::make('can_register')
                            ->label('Registration Available')
                            ->state(function ($record) {
                                if ($record->status === 'closed') {
                                    return 'Event Closed';
                                }
                                $reg = $record->registrations()->where('user_id', Auth::id())->latest()->first();
                                if (!$reg) return 'Open for Registration';
                                return match ($reg->status) {
                                    'accepted' => 'Already Registered',
                                    'pending' => 'Under Review',
                                    'rejected' => 'Registration Rejected',
                                    default => 'Open for Registration',
                                };
                            })
                            ->badge()
                            ->color(function ($record) {
                                if ($record->status === 'closed') return 'danger';
                                $reg = $record->registrations()->where('user_id', Auth::id())->latest()->first();
                                if (!$reg) return 'info';
                                return match ($reg->status) {
                                    'accepted' => 'success',
                                    'pending' => 'warning',
                                    'rejected' => 'danger',
                                    default => 'info',
                                };
                            }),
                    ])
                    ->columns(2),

                Section::make('Your Attachments')
                    ->schema([
                        \Filament\Infolists\Components\ViewEntry::make('attachments_gallery')
                            ->view('filament.user.event-attachments')
                            ->viewData([
                                'attachments' => $currentRecord->attachments()
                                    ->where('user_id', Auth::id())
                                    ->latest()
                                    ->get(),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }
}
