<?php

namespace  App\Filament\Resources\UserResource\Pages;

use Filament\Pages\Actions\Action;
use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\CreateUser as FilamentCreateUser;

class CreateUser extends FilamentCreateUser
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
