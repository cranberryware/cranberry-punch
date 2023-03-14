<?php

namespace App\Filament\Resources;

use App\Enums\LeaveSessionStatus;
use App\Filament\Resources\LeaveSessionResource\Pages;
use App\Filament\Resources\LeaveSessionResource\RelationManagers;
use App\Models\LeaveSession;
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
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveSessionResource extends Resource
{
    protected static ?string $model = LeaveSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-leave-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.leave-sessions'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('title')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.title'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.leave.input.title'))
                        ->required(),
                    TextInput::make('description')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.description'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.leave.input.description')),
                    DatePicker::make('from')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.from'))
                        ->required(),
                    DatePicker::make('to')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.to'))
                        ->required(),
                    Select::make('status')
                        ->label(__('cranberry-punch::cranberry-punch.leave.input.status'))
                        ->options(LeaveSessionStatus::getStatuses())
                        ->default('inactive')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.title'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.description')),
                TextColumn::make('from')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.from'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('to')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.to'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('cranberry-punch::cranberry-punch.leave.input.status'))
                    ->searchable()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(LeaveSessionStatus::getStatuses()),
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
            'index' => Pages\ListLeaveSessions::route('/'),
            'create' => Pages\CreateLeaveSession::route('/create'),
            'edit' => Pages\EditLeaveSession::route('/{record}/edit'),
        ];
    }
}
