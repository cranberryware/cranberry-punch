<?php

namespace App\Filament\Resources;

use App\Enums\LeaveRequestStatus;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
                        ->required(),
                    Select::make('leave_type_id')
                        ->required()
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_type'))
                        ->relationship('leaveType', 'name'),
                    Select::make('leave_session_id')
                        ->required()
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_session'))
                        // ->relationship('leaveSession', 'title'),
                        ->options(function () {
                            $options = [];
                            $sessions = LeaveSession::where('status', 'active')->get();
                            foreach ($sessions as $session) {
                                $options[$session->id] = $session->title;
                            }
                            return $options;
                        }),
                    TextInput::make('short_description')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.short_description'))
                        ->required(),
                    TextInput::make('reason')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.reason'))
                        ->required(),
                    DatePicker::make('from')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.from'))
                        ->required()
                        ->timezone(config('app.timezone'))
                        ->reactive()
                        ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                            if (Carbon::parse($state)->gt(Carbon::parse($get('to')))) {
                                $set('to', Carbon::parse($state)->addDay(1)->format('Y-m-d'));
                            }
                        }),
                    DatePicker::make('to')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.to'))
                        ->required()
                        ->timezone(config('app.timezone'))
                        ->reactive()
                        ->afterStateUpdated(function ($state, Closure $set, Closure $get) {
                            if (Carbon::parse($state)->lt(Carbon::parse($get('from')))) {
                                $set('from', Carbon::parse($state)->subDay(1)->format('Y-m-d'));
                            }
                        }),
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
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(LeaveRequestStatus::getStatuses()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('change_status_to_cancelled')
                        ->label(function (LeaveRequest $record) {
                            if ($record->status === LeaveRequestStatus::DRAFT()->value) {
                                return strval(__('cranberry-punch::cranberry-punch.leave-request-action.status.cancel'));
                            }
                        })
                        ->icon(function (LeaveRequest $record): string {
                            return ($record->status === LeaveRequestStatus::DRAFT()->value)
                                ? 'heroicon-o-x-circle'
                                : 'heroicon-o-clock';
                        })
                        ->color(function (LeaveRequest $record): string {
                            return ($record->status === LeaveRequestStatus::DRAFT()->value)
                                ? 'danger'
                                : 'warning';
                        })
                        ->action(function (LeaveRequest $record): void {
                            $record->setAttribute('status', $record->status === LeaveRequestStatus::DRAFT()->value ? LeaveRequestStatus::CANCELLED()->value : LeaveRequestStatus::DRAFT()->value)->save();
                        })
                        ->hidden(function (LeaveRequest $record) {
                            if (auth()->user()->hasRole(['hr-manager', 'super-admin'])) {
                                return true;
                            }
                            return ($record->status !== LeaveRequestStatus::DRAFT()->value && !auth()->user()->hasRole(['hr-manager', 'super-admin']));
                        })
                        ->requiresConfirmation(),

                        Tables\Actions\Action::make('change_status_to_submit')
                        ->label(function (LeaveRequest $record) {
                            if ($record->status === LeaveRequestStatus::DRAFT()->value) {
                                return strval(__('cranberry-punch::cranberry-punch.leave-request-action.status.submit'));
                            }
                        })
                        ->icon(function (LeaveRequest $record): string {
                            return ($record->status === LeaveRequestStatus::DRAFT()->value)
                                ? 'heroicon-o-check'
                                : 'heroicon-o-clock';
                        })
                        ->color(function (LeaveRequest $record): string {
                            return ($record->status === LeaveRequestStatus::DRAFT()->value)
                                ? 'success'
                                : 'warning';
                        })
                        ->action(function (LeaveRequest $record): void {
                            $record->setAttribute('status', $record->status === LeaveRequestStatus::DRAFT()->value ? LeaveRequestStatus::PENDING()->value : LeaveRequestStatus::DRAFT()->value)->save();
                        })
                        ->hidden(function (LeaveRequest $record) {
                            if (auth()->user()->hasRole(['hr-manager', 'super-admin'])) {
                                return true;
                            }
                            return ($record->status !== LeaveRequestStatus::DRAFT()->value && !auth()->user()->hasRole(['hr-manager', 'super-admin']));
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
