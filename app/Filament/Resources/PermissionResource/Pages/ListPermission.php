<?php

namespace  App\Filament\Resources\PermissionResource\Pages;

use Illuminate\Support\Facades\Config;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\ListPermissions as FilamentListPermissions;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;

class ListPermission extends FilamentListPermissions
{

    protected function getCreateAction(): Action
    {
        return CreateAction::make()->extraAttributes([
            'class' => 'custom-button'
        ]);
    }
}
