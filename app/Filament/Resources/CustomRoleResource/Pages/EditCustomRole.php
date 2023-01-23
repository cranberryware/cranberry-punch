<?php

namespace App\Filament\Resources\CustomRoleResource\Pages;

use App\Filament\Resources\CustomRoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomRole extends EditRecord
{
    protected static string $resource = CustomRoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
