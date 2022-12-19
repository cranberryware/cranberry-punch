<?php

namespace App\Filament\Resources\DesignationResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DesignationResource;
use Filament\Pages\Actions\Action;

class CreateDesignation extends CreateRecord
{
    protected static string $resource = DesignationResource::class;

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
