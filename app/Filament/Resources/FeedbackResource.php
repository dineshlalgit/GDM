<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as InfolistSection;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Feedback Management';

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Feedback';

    protected static ?string $pluralModelLabel = 'Feedbacks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // This form is not used for viewing, only for InfoList
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make('Feedback Information')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Full Name')
                            ->icon('heroicon-o-user')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('medium'),

                        TextEntry::make('email')
                            ->label('Email Address')
                            ->icon('heroicon-o-envelope')
                            ->copyable()
                            ->copyMessage('Email copied to clipboard'),

                        TextEntry::make('rating')
                            ->label('Rating')
                            ->icon('heroicon-o-star')
                            ->formatStateUsing(function ($state) {
                                $stars = str_repeat('⭐', $state);
                                return "{$stars} ({$state}/5)";
                            })
                            ->color('warning'),

                        TextEntry::make('message')
                            ->label('Feedback Message')
                            ->icon('heroicon-o-chat-bubble-left-ellipsis')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'active' => 'success',
                                'pending' => 'warning',
                                'rejected' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                    ])
                    ->columns(2),

                InfolistSection::make('System Information')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->icon('heroicon-o-computer-desktop')
                            ->copyable()
                            ->copyMessage('IP address copied to clipboard'),

                        TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->icon('heroicon-o-device-phone-mobile')
                            ->limit(50)
                            ->tooltip(function ($record) {
                                return $record->user_agent;
                            }),

                        TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->icon('heroicon-o-calendar-days')
                            ->dateTime('M j, Y g:i A')
                            ->color('success'),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->icon('heroicon-o-clock')
                            ->dateTime('M j, Y g:i A')
                            ->color('info'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied to clipboard'),

                ViewColumn::make('rating')
                    ->label('Rating')
                    ->view('components.rating-stars')
                    ->sortable(),

                // TextColumn::make('message')
                //     ->label('Message')
                //     ->limit(50)
                //     ->tooltip(function ($record) {
                //         return $record->message;
                //     })
                //     ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->copyable()
                    ->copyMessage('IP address copied to clipboard')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'rejected' => 'Rejected',
                    ]),

                SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ]),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->label('Date Range'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Details')
                    ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Feedback')
                    ->modalDescription('Are you sure you want to delete this feedback? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_active')
                        ->label('Mark as Active')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'active']);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Mark Feedbacks as Active')
                        ->modalDescription('Are you sure you want to mark the selected feedbacks as active?')
                        ->modalSubmitActionLabel('Yes, mark as active'),

                    Tables\Actions\BulkAction::make('mark_rejected')
                        ->label('Mark as Rejected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'rejected']);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Mark Feedbacks as Rejected')
                        ->modalDescription('Are you sure you want to mark the selected feedbacks as rejected?')
                        ->modalSubmitActionLabel('Yes, mark as rejected'),
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->requiresConfirmation()
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([25, 50, 100]);
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
            'index' => Pages\ListFeedbacks::route('/'),
            'view' => Pages\ViewFeedback::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() > 0 ? 'warning' : 'success';
    }
}
