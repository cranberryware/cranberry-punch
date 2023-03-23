<?php

namespace App\Filament\Resources;

use App\Enums\LeaveRequestStatus;
use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Filament\Resources\LeaveRequestResource\Widgets\LeaveRequestStatsOverview;
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

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Leave Apply';

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
                            $options = [];
                            $employees = auth()->user()->employee ? Employee::where('id', auth()->user()->employee->id)->get() : Employee::all();
                            foreach ($employees as $employee) {
                                $options[$employee->id] = $employee->employee_code_with_full_name;
                            }
                            return $options;
                        })
                        ->default(function () {
                            $options = [];
                            $employees = auth()->user()->employee ? Employee::where('id', auth()->user()->employee->id)->get() : [];
                            if (!$employees) return;
                            foreach ($employees as $employee) {
                                $options[$employee->id] = $employee->id;
                            }
                            return $options[$employee->id];
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
                        ->relationship('leaveType', 'name')
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set) {
                            $set('from', null);
                            $set('to', null);
                        }),
                    Select::make('leave_session_id')
                        ->required()
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_session'))
                        // ->relationship('leaveSession', 'title'),
                        ->relationship('leaveSession', 'title', function ($query) {
                            return $query->where('status', 'active');
                        }),
                    TextInput::make('short_description')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.short_description'))
                        ->required(),
                   
                    Textarea::make('reason')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.reason'))
                        ->required(),
                    Textarea::make('notes')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.notes'))
                        ->required(),

                    Grid::make(2)
                        ->schema([
                    DatePicker::make('from')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.from'))
                        ->required()
                        ->timezone(config('app.timezone'))
                        ->reactive()
                        ->minDate(
                            // Carbon::now()->format('Y-m-d')
                            function (Closure $get, Closure $set) {
                                $data = LeaveType::where('id', $get('leave_type_id'))->first();

                                if ($get('leave_type_id') && $get('employee_id') && $get('to')) {
                                    $minDate = null;
                                    // Convert the array to a Laravel Collection
                                    $collection = Collection::make($data->total_allowance);

                                    // Filter the collection to find the desired object
                                    $filtered = $collection->where('designation', auth()->user()->hasRole(['hr-manager', 'super-admin']) ? Employee::where('id', $get('employee_id'))->first()->designation->name : auth()->user()->employee->designation->name);

                                    // Extract the number_of_allowance value from the filtered object
                                    $number_of_allowance = $filtered->pluck('number_of_allowance')->first();

                                    if ($number_of_allowance > $data->claim_allowance_limit) {
                                        $minDate = $data->claim_allowance_limit;
                                    } else {
                                        $minDate = $number_of_allowance;
                                    }

                                    if (Carbon::parse($get('to'))->diff(Carbon::parse(now()->addDay($data->notify_before)->format('Y-m-d')))->days < $minDate) {
                                        return Carbon::now()->addDay($data->notify_before)->format('Y-m-d');
                                    } else {
                                        return Carbon::parse($get('to'))->subDay($minDate)->format('Y-m-d');
                                    }
                                }

                                if ($get('leave_type_id') && $get('employee_id')) {
                                    return Carbon::now()->addDay($data->notify_before)->format('Y-m-d');
                                }

                                if (!$get('leave_type_id') || !$get('employee_id') || !$get('to')) {
                                    return Carbon::now()->format('Y-m-d');
                                }
                            }
                        )
                        ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                            if (Carbon::parse($state)->gte(Carbon::parse($get('to'))) || !$get('to')) {
                                $set('to', Carbon::parse($state)->addDay(1)->format('Y-m-d'));
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
                                return Carbon::now()->addDay($data->notify_before + 1)->format('Y-m-d');
                            }
                            return Carbon::now()->addDay(1)->format('Y-m-d');
                        })
                        ->maxDate(function (Closure $get, Closure $set) {
                            if (!$get('leave_type_id') || !$get('employee_id') || !$get('from')) {
                                return;
                            }
                            $maxDate = null;
                            $data = LeaveType::where('id', $get('leave_type_id'))->first();
                            // Convert the array to a Laravel Collection
                            $collection = Collection::make($data->total_allowance);

                            // Filter the collection to find the desired object
                            $filtered = $collection->where('designation', auth()->user()->hasRole(['hr-manager', 'super-admin']) ? Employee::where('id', $get('employee_id'))->first()->designation->name : auth()->user()->employee->designation->name);

                            // Extract the number_of_allowance value from the filtered object
                            $number_of_allowance = $filtered->pluck('number_of_allowance')->first();

                            if ($number_of_allowance > $data->claim_allowance_limit) {
                                $maxDate = $data->claim_allowance_limit;
                            } else {
                                $maxDate = $number_of_allowance;
                            }
                            return Carbon::parse($get('from'))->addDay($maxDate)->format('Y-m-d');
                        })
                        ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                            if (Carbon::parse($state)->lte(Carbon::parse($get('from'))) || !$get('from')) {
                                $set('from', Carbon::parse($state)->subDay(1)->format('Y-m-d'));
                            }
                        }),
                    ]),
                    FileUpload::make('documents')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.document')),
                    select::make('status')
                        ->label('Status')
                        ->options(LeaveRequestStatus::getStatuses())
                        ->hidden(function () {
                            return auth()->user()->hasRole(['employee']);
                        })
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
                    Tables\Actions\Action::make('change_status_to_cancelled')
                        ->label(function (LeaveRequest $record) {
                            if ($record->status === LeaveRequestStatus::PENDING()->value) {
                                return strval(__('cranberry-punch::cranberry-punch.leave-request-action.status.cancel'));
                            }
                        })
                        ->icon(function (LeaveRequest $record): string {
                            return ($record->status === LeaveRequestStatus::PENDING()->value)
                                ? 'heroicon-o-x-circle'
                                : 'heroicon-o-clock';
                        })
                        ->color(function (LeaveRequest $record): string {
                            return ($record->status === LeaveRequestStatus::PENDING()->value)
                                ? 'danger'
                                : 'warning';
                        })
                        ->action(function (LeaveRequest $record): void {
                            $record->setAttribute('status', $record->status === LeaveRequestStatus::PENDING()->value ? LeaveRequestStatus::CANCELLED()->value : LeaveRequestStatus::PENDING()->value)->save();
                        })
                        ->hidden(function (LeaveRequest $record) {
                            if (auth()->user()->hasRole(['hr-manager', 'super-admin'])) {
                                return true;
                            }
                            return ($record->status !== LeaveRequestStatus::PENDING()->value && !auth()->user()->hasRole(['hr-manager', 'super-admin']));
                        })
                        ->requiresConfirmation(),
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
}
