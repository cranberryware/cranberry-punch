<?php

namespace  App\Filament\Resources\PermissionResource\Pages;

use Filament\Pages\Actions\Action;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\EditPermission as FilamentEditPermission;

class EditPermission extends FilamentEditPermission
{

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament::resources/pages/edit-record.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s'])
            ->extraAttributes([
                'class' => 'custom-button'
            ]);
    }
}
