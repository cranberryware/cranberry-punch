<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Attendance;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;
use App\Filament\Resources\AttendanceResource\RelationManagers;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('open-attendance::open-attendance.section.group-attendance-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('open-attendance::open-attendance.section.attendances'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label(__('open-attendance::open-attendance.attendance.input.employee'))
                    ->placeholder(__('open-attendance::open-attendance.attendance.input.employee'))
                    ->searchable()
                    ->relationship('employee', fn () => "employee_code_with_full_name")
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label(__('open-attendance::open-attendance.attendance.input.user'))
                    ->placeholder(__('open-attendance::open-attendance.attendance.input.user'))
                    ->searchable()
                    ->relationship('user', fn () => "name")
                    ->disabled(true)
                    ->required(),
                Forms\Components\DateTimePicker::make('check_in')
                    ->label(__('open-attendance::open-attendance.attendance.input.check-in'))
                    ->placeholder(__('open-attendance::open-attendance.attendance.input.check-in'))
                    ->required(),
                Forms\Components\DateTimePicker::make('check_out')
                    ->label(__('open-attendance::open-attendance.attendance.input.check-out'))
                    ->placeholder(__('open-attendance::open-attendance.attendance.input.check-out')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.employee_code_with_full_name')
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.employee-name-with-code')))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ViewColumn::make('check_in')
                    ->view('filament.tables.columns.attendance.clock-column')
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.check-in')))
                    ->sortable(),
                // Tables\Columns\TextColumn::make('check_in_location')
                //     ->label(strval(__('open-attendance::open-attendance.table.attendance.check-in-location')))
                //     ->sortable()
                //     ->searchable()
                //     ->hidden(true),
                Tables\Columns\ViewColumn::make('check_out')
                    ->view('filament.tables.columns.attendance.clock-column')
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.check-out')))
                    ->sortable(),
                // Tables\Columns\TextColumn::make('check_out_location')
                //     ->label(strval(__('open-attendance::open-attendance.table.attendance.check-out-location')))
                //     ->sortable()
                //     ->searchable()
                //     ->hidden(true),
                Tables\Columns\TextColumn::make('worked_hours_rounded')
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.worked-hours')))
                    ->sortable(['worked_hours'])
                    ->alignCenter(),
            ])
            ->defaultSort('check_in', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                DateFilter::make('check_in'),
                TextFilter::make('check_in_ip'),
                DateFilter::make('check_out'),
                TextFilter::make('check_out_ip'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
