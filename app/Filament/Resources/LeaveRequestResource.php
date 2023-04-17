<?php

namespace App\Filament\Resources;

use App\Enums\LeaveRequestStatus;
use App\Enums\LeaveSessionStatus;
use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Filament\Resources\LeaveRequestResource\Widgets\LeaveRequestStatsOverview;
use App\Helpers\Helper\Helper;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveSession;
use App\Models\LeaveType;
use Carbon\Carbon;
use Closure;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 2;

    public static function enforceFieldPermissions(Closure $get) {
        return (auth()->user()->hasRole(['hr-manager', 'super-admin'])) ? false : ($get('employee_id') !== auth()->user()->employee->id);
    }

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-leave-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.leave-requests'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('employee_id')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.employee'))
                        // ->relationship('employee', fn () => "employee_code_with_full_name")
                        ->searchable()
                        ->options(function () {
                            $employees = optional(auth()->user()->employee)->get() ?? Employee::all();
                            return $employees->pluck('employee_code_with_full_name', 'id');
                        })
                        ->default(function () {
                            return auth()->user()->employee->id ?? [];
                        })
                        ->disabled(!auth()->user()->hasRole(['hr-manager', 'super-admin']))
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set) {
                            $set('from', null);
                            $set('to', null);
                        }),
                    Select::make('leave_type_id')
                        ->required()
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_type'))
                        ->disabled(function(Closure $get){return self::enforceFieldPermissions($get);})
                        ->relationship('leaveType', 'name')
                        ->reactive()
                        ->afterStateUpdated(function ($state, Closure $set) {
                            $set('from', null);
                            $set('to', null);
                            $set('leave_type_description', LeaveType::find($state)->description);
                        }),
                    Textarea::make('leave_type_description')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_type_description'))
                        ->disabled(),
                    Select::make('leave_session_id')
                        ->required()
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_session'))
                        ->disabled(function(Closure $get){return self::enforceFieldPermissions($get);})
                        ->relationship('leaveSession', 'title', function ($query) {
                            return $query->where('status', LeaveSessionStatus::ACTIVE());
                        }),
                    TextInput::make('short_description')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.short_description'))
                        ->disabled(function(Closure $get){return self::enforceFieldPermissions($get);})
                        ->required(),

                    Textarea::make('reason')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.reason'))
                        ->disabled(function(Closure $get){return self::enforceFieldPermissions($get);})
                        ->required(),
                    Textarea::make('notes')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.notes'))
                        ->disabled(function(Closure $get) {
                            return (auth()->user()->hasRole(['hr-manager', 'super-admin'])) ? false : ($get('employee_id') == auth()->user()->employee->id);
                        }),

                    Grid::make(2)
                        ->schema([
                            DatePicker::make('from')
                                ->label(__('cranberry-punch::cranberry-punch.leave.input.from'))
                                ->required()
                                ->timezone(config('app.timezone'))
                                ->reactive()
                                ->minDate(
                                    function (Closure $get, Closure $set) {
                                        $leave_type_id = $get('leave_type_id');
                                        $employee_id = $get('employee_id');
                                        $to_date = $get('to');

                                        if (!$leave_type_id || !$employee_id) {
                                            return Carbon::now()->format('Y-m-d');
                                        }

                                        // fetch leave type data.
                                        $leave_type = LeaveType::where('id', $leave_type_id)->first();

                                        // leave type allowances
                                        $leave_allowances = Collection::make($leave_type->total_allowance);

                                        if ($to_date) {
                                            // get leave allowances for the designations
                                            $employee = Employee::where('id', $employee_id)->first();
                                            $designation_leave_allowances = $leave_allowances->where('designation', $employee->designation ? $employee->designation->name : '');

                                            // leave allowances for the particular employee
                                            $employee_claim_allowances_limit = $designation_leave_allowances->isNotEmpty() ? $designation_leave_allowances->pluck('claim_allowance_limit')->first() : $leave_type->default_claim_allowance_limit;

                                            return Carbon::parse($to_date)->subDay($employee_claim_allowances_limit)->format('Y-m-d');
                                        }

                                        return Carbon::now()->addDay($leave_type->notify_before)->format('Y-m-d');
                                    }
                                )
                                ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                                    if (Carbon::parse($state)->gte(Carbon::parse($get('to'))) || !$get('to')) {
                                        $set('to', Carbon::parse($state)->format('Y-m-d'));
                                    }
                                }),
                            DatePicker::make('to')
                                ->label(__('cranberry-punch::cranberry-punch.leave.input.to'))
                                ->required()
                                ->timezone(config('app.timezone'))
                                ->reactive()
                                ->minDate(function (Closure $get, Closure $set) {
                                    if ($get('leave_type_id')) {
                                        $data = LeaveType::where('id', $get('leave_type_id'))->first();
                                        return Carbon::now()->addDay($data->notify_before)->format('Y-m-d');
                                    }
                                    return Carbon::now()->addDay(1)->format('Y-m-d');
                                })
                                ->maxDate(function (Closure $get, Closure $set) {
                                    $leave_type_id = $get('leave_type_id');
                                    $employee_id = $get('employee_id');
                                    $from_date = $get('from');

                                    if (!$leave_type_id || !$employee_id || !$from_date) {
                                        return;
                                    }

                                    // fetch leave type data.
                                    $leave_type = LeaveType::where('id', $leave_type_id)->first();

                                    // leave type allowances
                                    $leave_allowances = Collection::make($leave_type->total_allowance);

                                    $employee = Employee::where('id', $employee_id)->first();

                                    // get leave allowances for the designations
                                    $designation_leave_allowances = $leave_allowances->where('designation', $employee->designation ? $employee->designation->name : '');

                                    // leave allowances for the particular employee
                                    $employee_claim_allowances_limit = $designation_leave_allowances->isNotEmpty() ? $designation_leave_allowances->pluck('claim_allowance_limit')->first() : $leave_type->default_claim_allowance_limit;

                                    return Carbon::parse($from_date)->addDay($employee_claim_allowances_limit)->format('Y-m-d');
                                })
                                ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                                    if (Carbon::parse($state)->lte(Carbon::parse($get('from'))) || !$get('from')) {
                                        $set('from', Carbon::parse($state)->format('Y-m-d'));
                                    }
                                }),
                        ]),
                    FileUpload::make('documents')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.document')),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.employee_code_with_full_name')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.employee-name-with-code')))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('leaveType.name')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.leave_type'))),
                TextColumn::make('duration')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.duration'))),
                TextColumn::make('from')
                    ->date()
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.from'))),
                TextColumn::make('to')
                    ->date()
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.to'))),
                ImageColumn::make('documents')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.document'))),
                BadgeColumn::make('status')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.status')))
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return (__("cranberry-punch::cranberry-punch.leave-request.status.{$state}"));
                    })
                    ->colors(LeaveRequestStatus::getStatusColors()),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(LeaveRequestStatus::getStatuses()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
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

    public static function getWidgets(): array
    {
        return [
            LeaveRequestStatsOverview::class,
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
