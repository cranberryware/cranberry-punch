<?php

namespace  App\Filament\Resources\RoleResource\Pages;

use Illuminate\Support\Facades\Config;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\ListRoles as FilamentListRole;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;

class ListRoles extends FilamentListRole
{

    protected function getCreateAction(): Action
    {
        return CreateAction::make()->extraAttributes([
            'class' => 'custom-button'
        ]);
    }
}
