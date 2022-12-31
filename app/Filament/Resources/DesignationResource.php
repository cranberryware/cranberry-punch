<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Designation;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DesignationResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\DesignationResource\RelationManagers;

class DesignationResource extends Resource
{
    protected static ?string $model = Designation::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';


    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-employee-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.designations'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->label(strval(__('cranberry-punch::cranberry-punch.form.designation.name')))
                        ->placeholder(strval(__('cranberry-punch::cranberry-punch.form.designation.name')))
                        ->required(),
                    Select::make('department_id')
                        ->label(strval(__('cranberry-punch::cranberry-punch.form.input.designation.department')))
                        ->placeholder(strval(__('cranberry-punch::cranberry-punch.form.input.designation.department')))
                        ->relationship('department', fn () => "name"),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('cranberry-punch::cranberry-punch.table.designation.name'))
                    ->sortable(),
                TextColumn::make('department.name')
                    ->label(__('cranberry-punch::cranberry-punch.table.department.name'))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                ExportBulkAction::make(),
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
            'index' => Pages\ListDesignations::route('/'),
            'create' => Pages\CreateDesignation::route('/create'),
            'edit' => Pages\EditDesignation::route('/{record}/edit'),
        ];
    }
}
