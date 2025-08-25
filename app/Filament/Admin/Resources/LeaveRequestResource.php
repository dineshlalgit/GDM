<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LeaveRequestResource\Pages;
use App\Filament\Admin\Resources\LeaveRequestResource\RelationManagers;
use App\Models\LeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
                Forms\Components\DatePicker::make('from_date')
                    ->label('From Date')
                    ->required()
                    ->minDate(now()),
                Forms\Components\DatePicker::make('to_date')
                    ->label('To Date')
                    ->required()
                    ->minDate(now()),
                Forms\Components\Select::make('leave_type')
                    ->label('Leave Type')
                    ->options([
                        'medical' => 'Medical',
                        'casual' => 'Casual',
                        'earned' => 'Earned',
                        'other' => 'Other',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('medical_reason')
                    ->label('Medical Reason')
                    ->rows(3),
                Forms\Components\Hidden::make('status')
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('to_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('leave_type')->label('Leave Type')->sortable(),
                Tables\Columns\TextColumn::make('medical_reason')->label('Reason')->limit(30),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Approved By')
                    ->searchable()
                    ->visible(fn($record) => $record && $record->status !== 'pending'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
