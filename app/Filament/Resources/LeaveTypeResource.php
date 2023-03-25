<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveTypeResource\Pages;
use App\Filament\Resources\LeaveTypeResource\RelationManagers;
use App\Models\Designation;
use App\Models\LeaveType;
use Closure;
use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveTypeResource extends Resource
{
    protected static ?string $model = LeaveType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-leave-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.leave-types'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')->reactive()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('slug', Str::slug($state));
                        })
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.name'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.leave.input.name'))
                        ->required(),
                    TextInput::make('slug')
                        ->required(),
                    TextInput::make('description')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.description'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.leave.input.description')),
                    // KeyValue::make('total_allowance')
                    //     ->keyLabel('Designation')
                    //     ->valueLabel('No. of Allowance'),
                    Repeater::make('total_allowance')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.total_allowance'))
                        ->schema([
                            Select::make('designation')
                                ->label(__('cranberry-punch::cranberry-punch.leave.input.designation'))
                                ->options(Designation::all('name')->pluck('name', 'name'))
                                ->searchable()
                                ->required(),
                            TextInput::make('number_of_allowance')
                                ->label(__('cranberry-punch::cranberry-punch.leave.input.number_of_allowance'))
                                ->required(),
                            TextInput::make('claim_allowance_limit')
                                ->label(__('cranberry-punch::cranberry-punch.leave.input.claim_allowance_limit'))
                                ->lte('number_of_allowance')
                                ->required(),
                        ])
                        ->required()
                        ->columns(3),
                    TextInput::make('default_allowance_limit')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.default_allowance_limit'))
                        ->numeric()
                        ->required(),
                    TextInput::make('default_claim_allowance_limit')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.default_claim_allowance_limit'))
                        ->numeric()
                        ->lte('default_allowance_limit')
                        ->required(),
                    TextInput::make('notify_before')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.notify_before'))
                        ->numeric()
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.slug')),
                TextColumn::make('description')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.description')),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLeaveTypes::route('/'),
            'create' => Pages\CreateLeaveType::route('/create'),
            'edit' => Pages\EditLeaveType::route('/{record}/edit'),
        ];
    }
}
