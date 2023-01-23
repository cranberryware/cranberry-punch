<?php

namespace App\Filament\Resources\CustomRoleResource\CustomRelationManager;

use App\Filament\Resources\CustomRoleResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Phpsa\FilamentAuthentication\Resources\RoleResource\RelationManager\PermissionRelationManager ;

class CustomPermissionRelationManager extends PermissionRelationManager
{
    // protected static string $resource = CustomPermissionResource::class;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique()
                    ->label(strval(__('filament-authentication::filament-authentication.field.name'))),
                TextInput::make('guard_name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                     ->default(config('auth.defaults.guard')),
            ]);
    }
    

}
