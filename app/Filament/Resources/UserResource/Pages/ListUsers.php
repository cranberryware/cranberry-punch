<?php

namespace  App\Filament\Resources\UserResource\Pages;

use Illuminate\Support\Facades\Config;
use Phpsa\FilamentAuthentication\Resources\UserResource\Pages\ListUsers as FilamentListUser;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;

class ListUsers extends FilamentListUser
{

    protected function getCreateAction(): Action
    {
        return CreateAction::make()->extraAttributes([
            'class' => 'custom-button'
        ]);
    }
}
