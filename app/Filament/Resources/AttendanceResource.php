<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Attendance;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use Illuminate\Support\Carbon;

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
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in')->dateTime()
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.check-in')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in_location')
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.check-in-location')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out')->dateTime()
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.check-out')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out_location')
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.check-out-location')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('worked_hours_rounded')
                    ->label(strval(__('open-attendance::open-attendance.table.attendance.worked-hours')))
                    ->sortable(['worked_hours']),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
            ])
            ->defaultSort('check_in', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('check_in')
                    ->form([
                        Fieldset::make(__('open-attendance::open-attendance.attendance.section.check-in'))
                            ->schema([
                                Forms\Components\DateTimePicker::make('check_in_from')
                                    ->label('')
                                    ->placeholder(__('open-attendance::open-attendance.attendance.section.check-in.check-in-from')),
                                Forms\Components\DateTimePicker::make('check_in_until')
                                    ->label('')
                                    ->placeholder(__('open-attendance::open-attendance.attendance.section.check-in.check-in-until')),
                            ])
                            ->extraAttributes([
                                'style' => 'padding: 15px!important'
                            ])
                            ->columns(2)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['check_in_from'],
                                fn (Builder $query, $datetime): Builder => $query->where('check_in', '>=', Carbon::parse($datetime, config('app.user_timezone'))->tz('UTC')),
                            )
                            ->when(
                                $data['check_in_until'],
                                fn (Builder $query, $datetime): Builder => $query->where('check_in', '<=', Carbon::parse($datetime, config('app.user_timezone'))->tz('UTC')),
                            );
                    }),
                Tables\Filters\Filter::make('check_out')
                    ->form([
                        Fieldset::make(__('open-attendance::open-attendance.attendance.section.check-out'))
                            ->schema([
                                Forms\Components\DateTimePicker::make('check_out_from')
                                    ->label('')
                                    ->placeholder(__('open-attendance::open-attendance.attendance.section.check-out.check-out-from')),
                                Forms\Components\DateTimePicker::make('check_out_until')
                                    ->label('')
                                    ->placeholder(__('open-attendance::open-attendance.attendance.section.check-out.check-out-until')),
                            ])
                            ->extraAttributes([
                                'style' => 'padding: 15px!important'
                            ])
                            ->columns(2)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['check_out_from'],
                                fn (Builder $query, $datetime): Builder => $query->where('check_out', '>=', Carbon::parse($datetime, config('app.user_timezone'))->tz('UTC')),
                            )
                            ->when(
                                $data['check_out_until'],
                                fn (Builder $query, $datetime): Builder => $query->where('check_out', '<=', Carbon::parse($datetime, config('app.user_timezone'))->tz('UTC')),
                            );
                    })

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
