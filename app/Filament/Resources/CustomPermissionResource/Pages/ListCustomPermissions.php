<?php

namespace App\Filament\Resources\CustomPermissionResource\Pages;

use App\Filament\Resources\CustomPermissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomPermissions extends ListRecords
{
    protected static string $resource = CustomPermissionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
