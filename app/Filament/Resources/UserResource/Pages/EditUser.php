<?php

namespace  App\Filament\Resources\UserResource\Pages;

use Filament\Pages\Actions\Action;
use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\EditUser as FilamentEditUser;

class EditUser extends FilamentEditUser
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
