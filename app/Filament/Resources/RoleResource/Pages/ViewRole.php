<?php

namespace  App\Filament\Resources\RoleResource\Pages;

use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\ViewRole as FilamentViewRole;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;

class ViewRole extends FilamentViewRole
{

    protected function getEditAction(): Action
    {
        return EditAction::make()
            ->extraAttributes([
                'class' => 'custom-button'
            ]);
    }
}
