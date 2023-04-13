<?php

namespace App\Filament\Resources;

use App\Enums\LeaveSessionStatus;
use App\Filament\Resources\LeaveBalanceResource\Pages;
use App\Filament\Resources\LeaveBalanceResource\RelationManagers;
use App\Helpers\Helper\Helper;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveSession;
use App\Models\LeaveType;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveBalanceResource extends Resource
{
    protected static ?string $model = LeaveBalance::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?int $navigationSort = 3;

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-leave-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.leave-balances'));
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
                        ->reactive(), 
                    Select::make('leave_type_id')
                        ->required()
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_type'))
                        ->disabled(function (Closure $get) {
                            return Helper::manageRoll($get);
                        })
                        ->relationship('leaveType', 'name')
                        ->reactive(),
                    Select::make('leave_session_id')
                        ->required()
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.leave_session'))
                        ->disabled(function (Closure $get) {
                            return Helper::manageRoll($get);
                        })
                        ->relationship('leaveSession', 'title', function ($query) {
                            return $query->where('status', LeaveSessionStatus::ACTIVE());
                        }),
                    TextInput::make('used')
                        ->label(__('cranberry-punch::cranberry-punch.table.leave.used'))
                        ->numeric()
                        ->required(),
                    TextInput::make('available')
                        ->label(__('cranberry-punch::cranberry-punch.table.leave.available'))
                        ->numeric()
                        ->required()
                ]),

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
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.leave_type')))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('leaveSession.title')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.leave_session')))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('used')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.used')))
                    ->sortable(),
                TextColumn::make('available')
                    ->label(strval(__('cranberry-punch::cranberry-punch.table.leave.available')))
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLeaveBalances::route('/'),
            'create' => Pages\CreateLeaveBalance::route('/create'),
            'edit' => Pages\EditLeaveBalance::route('/{record}/edit'),
        ];
    }
}
