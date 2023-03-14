<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveSession;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('employee_id')
                        ->label('Employee')
                        ->id(auth()->user()->employee->id)
                        ->default(auth()->user()->employee->employee_code_with_full_name)
                        ->disabled(),
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
                        ->required(),
                    DatePicker::make('to')
                        ->required(),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
