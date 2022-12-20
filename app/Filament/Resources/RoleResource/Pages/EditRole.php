<?php

namespace  App\Filament\Resources\RoleResource\Pages;

use Filament\Pages\Actions\Action;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\EditRole as FilamentEditRole;

class EditRole extends FilamentEditRole
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
