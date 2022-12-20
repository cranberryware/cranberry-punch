<?php

namespace  App\Filament\Resources\PermissionResource\Pages;

use Filament\Pages\Actions\Action;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\CreatePermission as FilamentCreatePermission;

class CreatePermission extends FilamentCreatePermission
{

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('filament::resources/pages/create-record.form.actions.create.label'))
            ->submit('create')
            ->keyBindings(['mod+s'])
            ->extraAttributes([
                'class' => 'custom-button'
            ]);
    }
}
