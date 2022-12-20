<?php

namespace  App\Filament\Resources\UserResource\Pages;

use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\ViewUser as FilamentViewUser;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;

class ViewUser extends FilamentViewUser
{

    protected function getEditAction(): Action
    {
        return EditAction::make()
            ->extraAttributes([
                'class' => 'custom-button'
            ]);
    }
}
