<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomPermissionResource\CustomRelationManager\CustomRoleRelationManager;
use App\Filament\Resources\CustomPermissionResource\Pages;
use App\Filament\Resources\CustomPermissionResource\RelationManagers;
use App\Models\CustomPermission;
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
use Phpsa\FilamentAuthentication\Resources\PermissionResource;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\RelationManager\RoleRelationManager;
use Spatie\Permission\Models\Permission as ModelsPermission;

class CustomPermissionResource extends PermissionResource
{
    protected static ?string $model = ModelsPermission::class;

    // protected static ?string $navigationIcon = 'heroicon-o-collection';

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
            CustomRoleRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomPermissions::route('/'),
            'create' => Pages\CreateCustomPermission::route('/create'),
            'edit' => Pages\EditCustomPermission::route('/{record}/edit'),
        ];
    }    
}
