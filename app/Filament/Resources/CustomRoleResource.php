<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomRoleResource\CustomRelationManager\CustomPermissionRelationManager;
use App\Filament\Resources\CustomRoleResource\Pages;
use App\Filament\Resources\CustomRoleResource\RelationManagers;
use App\Models\CustomRole;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Phpsa\FilamentAuthentication\Resources\RoleResource ;
use Spatie\Permission\Models\Role;

class CustomRoleResource extends RoleResource
{
    protected static ?string $model = Role::class;
    // protected static ?string $model = Role::class;


    // protected static ?string $navigationIcon = 'heroicon-o-collection';

    // public function __construct()
    // {
    //     static::$model = config('filament-authentication.models.CustomRole');
    // }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([
                    Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                        ->unique()
                        ->label(strval(__('filament-authentication::filament-authentication.field.name')))
                        ->required(),
                        TextInput::make('guard_name')
                        ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                        ->required()
                        ->default(config('auth.defaults.guard')),
                    ])
            
        ])

    ]);
    }

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             //
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make(),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\DeleteBulkAction::make(),
    //         ]);
    // }
    
    
    public static function getRelations(): array
    {
        return [
            CustomPermissionRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomRoles::route('/'),
            'create' => Pages\CreateCustomRole::route('/create'),
            'edit' => Pages\EditCustomRole::route('/{record}/edit'),
        ];
    }    
}
