<?php

namespace  App\Filament\Resources\RoleResource\Pages;

use Filament\Pages\Actions\Action;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\CreateRole as FilamentCreateRole;

class CreateRole extends FilamentCreateRole
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
