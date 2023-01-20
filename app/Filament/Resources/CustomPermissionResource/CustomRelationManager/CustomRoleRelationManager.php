<?php

namespace App\Filament\Resources\CustomPermissionResource\CustomRelationManager;

use App\Filament\Resources\CustomPermissionResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\RelationManager\RoleRelationManager;

class CustomRoleRelationManager extends RoleRelationManager
{
    // protected static string $resource = CustomPermissionResource::class;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique()
                    ->label(strval(__('filament-authentication::filament-authentication.field.test'))),
                TextInput::make('guard_name')
                    ->label(strval(__('filament-authentication::filament-authentication.field.guard_name')))
                     ->default(config('auth.defaults.guard')),
            ]);
    }
    

}
