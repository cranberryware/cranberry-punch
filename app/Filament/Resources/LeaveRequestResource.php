<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveSession;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-leave-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.leave-requests'));
    }

    public static function getDuration($from, $to)
    {
        $startDate = Carbon::parse($from);
        $endDate = Carbon::parse($to);

        $duration = $startDate->diff($endDate)->days;
        return $duration;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('employee_id')
                        ->label('Employee')
                        // ->relationship('employee', fn () => "employee_code_with_full_name")
                        ->searchable()
                        ->options(function () {
                            $options = [];
                            $employees = auth()->user()->employee ? Employee::where('id', auth()->user()->employee->id)->get() : Employee::all();
                            foreach ($employees as $employee) {
                                $options[$employee->id] = $employee->employee_code_with_full_name;
                            }
                            return $options;
                        })
                        ->required(),
                    Select::make('leave_type_id')
                        ->required()
                        ->label('Leave Type')
                        ->relationship('leaveType', 'name'),
                    Select::make('leave_session_id')
                        ->required()
                        ->label('Leave Session')
                        ->options(function () {
                            $options = [];
                            $sessions = LeaveSession::where('status', 'active')->get();
                            foreach ($sessions as $session) {
                                $options[$session->id] = "{$session->from} - {$session->to}";
                            }
                            return $options;
                        }),
                    TextInput::make('short_description')
                        ->label('Short Description')
                        ->required(),
                    TextInput::make('reason')
                        ->label('Reason')
                        ->required(),
                    DatePicker::make('from')
                        ->required()
                        ->reactive()
                        ->minDate(Carbon::now())
                        ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                            if (Carbon::parse($state)->gt(Carbon::parse($get('to')))) {
                                $set('to', Carbon::parse($state)->addDay(1)->format('Y-m-d'));
                                $set('duration', self::getDuration($get('to'), $state));
                            }
                            $set('duration', self::getDuration($get('to'), $state));
                        }),
                    DatePicker::make('to')
                        ->required()
                        ->reactive()
                        ->minDate(Carbon::now())
                        ->afterOrEqual('from')
                        ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                            if (Carbon::parse($state)->lt(Carbon::parse($get('from')))) {
                                $set('from', Carbon::parse($state)->subDay(1)->format('Y-m-d'));
                                $set('duration', self::getDuration($get('from'), $state));
                            }
                            $set('duration', self::getDuration($get('from'), $state));
                        }),
                    Hidden::make('duration')
                        ->label('Duration')
                        ->required()
                        ->disabled(),
                    DatePicker::make('applied_on')
                        ->required()
                        ->default(Carbon::now())


                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.employee_code_with_full_name')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.attendance.employee-name-with-code')))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('leaveType.name'),
                TextColumn::make('duration'),
                TextColumn::make('from')->date(),
                TextColumn::make('to')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
