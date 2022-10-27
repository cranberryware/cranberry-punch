<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Support\Str;
use Filament\Tables;
use App\Models\Department;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DepartmentResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\DepartmentResource\RelationManagers;
use App\Rules\NumericallyDifferent;
use Filament\Forms\Components\Textarea;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';


    protected static function getNavigationGroup(): ?string
    {
        return strval(__('open-attendance::open-attendance.section.group-employee-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('open-attendance::open-attendance.section.departments'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->label(strval(__('open-attendance::open-attendance.form.input.department.name')))
                        ->placeholder(strval(__('open-attendance::open-attendance.form.input.department.name')))
                        ->required(),
                    Textarea::make('description')
                        ->label(strval(__('open-attendance::open-attendance.form.input.department.description')))
                        ->placeholder(strval(__('open-attendance::open-attendance.form.input.department.description')))
                        ->required(),
                    Select::make('parent_id')
                        ->label(strval(__('open-attendance::open-attendance.form.input.department.parent_department')))
                        ->placeholder(strval(__('open-attendance::open-attendance.form.input.department.parent_department')))
                        ->relationship('parent_department', fn () => "name")
                        ->rules([
                            new NumericallyDifferent(['data.id'], __('open-attendance::open-attendance.form.input.department.parent_department_cannot_be_same')),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('open-attendance::open-attendance.table.department.name'))
                    ->sortable(),
                TextColumn::make('description')
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
