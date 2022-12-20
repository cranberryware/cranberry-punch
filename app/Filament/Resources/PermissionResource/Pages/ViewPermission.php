<?php

namespace  App\Filament\Resources\PermissionResource\Pages;

use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\ViewPermission as FilamentViewPermission;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;

class ViewPermission extends FilamentViewPermission
{

    protected function getEditAction(): Action
    {
        return EditAction::make()
            ->extraAttributes([
                'class' => 'custom-button'
            ]);
    }
}
