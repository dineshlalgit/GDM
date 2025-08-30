<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\FileResource\Pages;
use App\Filament\User\Resources\FileResource\RelationManagers;
use App\Models\MediaFile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FileResource extends Resource
{
    protected static ?string $model = MediaFile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            FileUpload::make('file_path')
                ->label('Media File')
                ->required()
                ->disk('public')
                ->directory('media')
                ->preserveFilenames()
                ->getUploadedFileNameForStorageUsing(fn ($file) => $file->getClientOriginalName())
                ->maxSize(502400)
                ->acceptedFileTypes([
                    // iPhone Photos
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/heic',
                    'image/heif',
                    'image/webp',
                    'image/gif',
                    'image/bmp',
                    'image/tiff',

                    // iPhone Videos
                    'video/mp4',
                    'video/mov',
                    'video/m4v',
                    'video/3gpp',
                    'video/3gpp2',
                    'video/quicktime',
                    'video/x-msvideo',
                    'video/x-ms-wmv',
                    'video/x-flv',
                    'video/webm',
                    'video/ogg',

                    // iPhone Audio
                    'audio/mpeg',
                    'audio/mp3',
                    'audio/mp4',
                    'audio/m4a',
                    'audio/aac',
                    'audio/wav',
                    'audio/ogg',
                    'audio/flac',
                    'audio/x-m4a',
                    'audio/x-aiff',
                    'audio/x-caf',

                    // iPhone Documents & Files
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/zip',
                    'application/x-rar-compressed',
                    'application/x-7z-compressed',
                    'application/x-tar',
                    'application/gzip',
                    'application/x-gzip',
                    'text/plain',
                    'text/csv',
                    'text/html',
                    'text/css',
                    'text/javascript',
                    'application/json',
                    'application/xml',
                    'text/xml',
                ])
                ->acceptedFileExtensions([
                    // iPhone Photos
                    'jpg', 'jpeg', 'png', 'heic', 'heif', 'webp', 'gif', 'bmp', 'tiff',

                    // iPhone Videos
                    'mp4', 'mov', 'm4v', '3gp', '3gpp', '3g2', '3gpp2', 'avi', 'wmv', 'flv', 'webm', 'ogg',

                    // iPhone Audio
                    'mp3', 'm4a', 'aac', 'wav', 'ogg', 'flac', 'aiff', 'caf',

                    // iPhone Documents & Files
                    'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', '7z', 'tar', 'gz', 'txt', 'csv', 'html', 'css', 'js', 'json', 'xml'
                ])
                ->helperText('Supported formats: Photos (JPG, PNG, HEIC, HEIF, WebP, GIF, BMP, TIFF), Videos (MP4, MOV, M4V, 3GP, AVI, WMV, FLV, WebM, OGG), Audio (MP3, M4A, AAC, WAV, OGG, FLAC, AIFF, CAF), Documents (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, 7Z, TXT, CSV, HTML, CSS, JS, JSON, XML)')
                ->afterStateUpdated(function ($state, $component) {
                    if ($state) {
                        Log::info('File upload attempt', [
                            'user_id' => Auth::id(),
                            'file_name' => $state->getClientOriginalName() ?? null,
                            'size_bytes' => $state->getSize() ?? null,
                        ]);
                    } else {
                        Log::warning('File upload state is null', [
                            'user_id' => Auth::id(),
                        ]);
                    }
                })
                ->rules([
                    new \App\Rules\FileWithinQuota,
                ]),

            Forms\Components\DateTimePicker::make('uploaded_at')
                ->label('Uploaded At')
                ->default(now())
                ->disabled(fn (string $context) => $context === 'create'),

            Forms\Components\Hidden::make('user_id')
                ->default(fn () => auth()->id())
                ->required(),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('File')
                    ->disk('public')
                    ->height(120)
                    ->width(120)
                    ->circular()
                    ->getStateUsing(function ($record) {
                        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        if (in_array(strtolower($record->file_type), $imageTypes)) {
                            return $record->file_path;
                        }
                        return 'media/icons/' . match (strtolower($record->file_type)) {
                            'mp4', 'mov', 'avi'         => 'video.png',
                            'mp3', 'wav', 'ogg' , 'mpeg'=> 'audio.webp',
                            'pdf'                       => 'pdf.png',
                            'doc', 'docx'               => 'msdoc.png',
                            'xls', 'xlsx'               => 'excel.png',
                            'ppt', 'pptx'               => 'ppt.png',
                            'zip', 'rar', '7z', 'tar', 'gz' => 'archive.png',
                            default                     => 'file.png',
                        };
                    })
                    ->url(fn ($record) => Storage::disk('public')->url($record->file_path)),
                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->getStateUsing(function ($record) {
                        $filePath = $record->file_path;
                        $fileName = basename($filePath);
                        if (str_starts_with($fileName, 'media/')) {
                            $fileName = substr($fileName, strlen('media/'));
                        }
                        $dotPos = strrpos($fileName, '.');
                        if ($dotPos !== false) {
                            $fileName = substr($fileName, 0, $dotPos);
                        }
                        return $fileName;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_type')->label('File Type')->sortable(),
                Tables\Columns\TextColumn::make('uploaded_at')->label('Uploaded At')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $filePath = $record->file_path;
                        $fileName = basename($filePath);
                        return response()->download(
                            Storage::disk('public')->path($filePath),
                            $fileName
                        );
                    })
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\MediaGallery::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
