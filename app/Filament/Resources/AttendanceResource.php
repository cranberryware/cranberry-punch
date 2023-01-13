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
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;
use App\Filament\Resources\AttendanceResource\RelationManagers;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-attendance-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.attendances'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label(__('cranberry-punch::cranberry-punch.attendance.input.employee'))
                    ->placeholder(__('cranberry-punch::cranberry-punch.attendance.input.employee'))
                    ->searchable()
                    ->relationship('employee', fn () => "employee_code_with_full_name")
                    ->extraAttributes(['class'=> 'cp-attendance-empId-field'])
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label(__('cranberry-punch::cranberry-punch.attendance.input.user'))
                    ->placeholder(__('cranberry-punch::cranberry-punch.attendance.input.user'))
                    ->searchable()
                    ->relationship('user', fn () => "name")
                    ->extraAttributes(['class'=> 'cp-attendance-user-field'])
                    ->disabled(!auth()->user()->hasRole(['hr-manager', 'super-admin']))
                    ->required(),
                Forms\Components\DateTimePicker::make('check_in')
                    ->label(__('cranberry-punch::cranberry-punch.attendance.input.check-in'))
                    ->placeholder(__('cranberry-punch::cranberry-punch.attendance.input.check-in'))
                    ->extraAttributes(['class'=> 'cp-checkin'])
                    ->required(),
                Forms\Components\DateTimePicker::make('check_out')
                    ->label(__('cranberry-punch::cranberry-punch.attendance.input.check-out'))
                    ->placeholder(__('cranberry-punch::cranberry-punch.attendance.input.check-out')),
            ]);
    }

    public static function table(Table $table): Table
    {
        $resource_slug = self::getSlug();
        $dynamic_columns = [
            "employee.full_name" => strval(__('cranberry-punch::cranberry-punch.table.attendance.employee.full_name')),
            "employee.employee_code" => strval(__('cranberry-punch::cranberry-punch.table.attendance.employee.employee_code'))
        ];

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.employee_code_with_full_name')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.employee-name-with-code')))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.full_name')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.employee.full_name')))
                    ->searchable()
                    ->hidden(function () use ($resource_slug) {
                        $column_hidden = request()->session()->get("{$resource_slug}::columns_hidden::employee.full_name");
                        $column_hidden = is_null($column_hidden) ? true : $column_hidden;
                        return $column_hidden;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.employee_code')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.employee.employee_code')))
                    ->searchable()
                    ->hidden(function () use ($resource_slug) {
                        $column_hidden = request()->session()->get("{$resource_slug}::columns_hidden::employee.employee_code");
                        $column_hidden = is_null($column_hidden) ? true : $column_hidden;
                        return $column_hidden;
                    })
                    ->sortable(),
                Tables\Columns\ViewColumn::make('check_in')
                    ->view('filament.tables.columns.attendance.clock-column')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.check-in')))
                    ->sortable(),
                Tables\Columns\ViewColumn::make('check_out')
                    ->view('filament.tables.columns.attendance.clock-column')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.check-out')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('worked_hours_rounded')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.worked-hours')))
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
            ])
            ->headerActions([
                Tables\Actions\Action::make('choose-columns')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.choose-columns')))
                    ->icon('heroicon-o-table')
                    ->form(function () use ($dynamic_columns, $resource_slug) {
                        return [
                            \Filament\Forms\Components\CheckboxList::make('chosen_table_columns')
                                ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.choose-columns')))
                                ->options($dynamic_columns)
                                ->default(function () use ($dynamic_columns, $resource_slug) {
                                    $chosen_columns = [];
                                    foreach ($dynamic_columns as $column_key => $column_value) {
                                        $sess_key = "{$resource_slug}::columns_hidden::{$column_key}";
                                        if(request()->session()->get($sess_key) === false) {
                                            $chosen_columns[] = $column_key;
                                        }
                                    }
                                    return $chosen_columns;
                                }),
                        ];
                    })
                    ->action(function (array $data) use ($resource_slug, $dynamic_columns): void {
                        $chosen_table_columns = $data['chosen_table_columns'];
                        foreach ($dynamic_columns as $column_key => $column_value) {
                            $sess_key = "{$resource_slug}::columns_hidden::{$column_key}";
                            if (in_array($column_key, $chosen_table_columns)) {
                                request()->session()->put($sess_key, false);
                            } else {
                                request()->session()->put($sess_key, true);
                            }
                        }
                        request()->session()->save();
                    })
                    ->visible(function () {
                        return (auth()->user()->hasRole(['hr-manager', 'super-admin']));
                    }),
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
            'attendance-calendar' => Pages\AttendanceCalendar::route('/calendar'),
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
