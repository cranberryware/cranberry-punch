<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\Pages\CreateRecord;
use Filament\Pages\Actions\Action;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

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
