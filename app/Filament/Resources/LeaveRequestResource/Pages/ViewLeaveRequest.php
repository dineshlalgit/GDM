<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class ViewLeaveRequest extends ViewRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function resolveRecord($key): \Illuminate\Database\Eloquent\Model
    {
        return static::getResource()::getEloquentQuery()
            ->with(['user', 'approver'])
            ->findOrFail($key);
    }

    public function getInfolistSchema(): array
    {
        return [
            Section::make('Leave Request Details')
                ->icon('heroicon-o-calendar-days')
                ->description('View detailed leave request information.')
                ->schema([
                    TextEntry::make('id')
                        ->label('Request ID')
                        ->icon('heroicon-o-identification'),

                    TextEntry::make('user.name')
                        ->label('Requested By')
                        ->placeholder('No user assigned')
                        ->icon('heroicon-o-user-circle'),

                    TextEntry::make('user.role.name')
                        ->label('Account Type')
                        ->badge()
                        ->color(fn($record) => match (optional($record->user->role)->name) {
                            'Staff' => 'success',
                            'Admin' => 'danger',
                            default => ($record->user && $record->user->role && $record->user->role->color ? $record->user->role->color : 'gray'),
                        })
                        ->icon('heroicon-o-users'),

                    TextEntry::make('leave_type')
                        ->label('Leave Type')
                        ->badge()
                        ->icon('heroicon-o-clipboard-document'),

                    TextEntry::make('medical_reason')
                        ->label('Reason')
                        ->placeholder('N/A')
                        ->icon('heroicon-o-chat-bubble-left-right'),
                ])
                ->columns(2),

            Section::make('Dates')
                ->icon('heroicon-o-calendar')
                ->schema([
                    TextEntry::make('from_date')
                        ->label('From Date')
                        ->icon('heroicon-o-arrow-right'),

                    TextEntry::make('to_date')
                        ->label('To Date')
                        ->icon('heroicon-o-arrow-left'),
                ])
                ->columns(2),

            Section::make('Approval Info')
                ->icon('heroicon-o-shield-check')
                ->schema([
                    TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'pending' => 'info',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        })
                        ->icon('heroicon-o-information-circle'),

                    TextEntry::make('approver.name')
                        ->label('Approved By')
                        ->placeholder('Not yet approved')
                        ->icon('heroicon-o-user-group'),
                ])
                ->columns(2),

            Section::make()
                ->schema([
                    TextEntry::make('created_at')
                        ->label('Submitted On')
                        ->dateTime()
                        ->icon('heroicon-o-clock'),
                ]),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema($this->getInfolistSchema());
    }
}
