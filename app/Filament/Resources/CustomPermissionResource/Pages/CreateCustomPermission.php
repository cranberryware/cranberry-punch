<?php

namespace App\Filament\Resources\CustomPermissionResource\Pages;

use App\Filament\Resources\CustomPermissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomPermission extends CreateRecord
{
    protected static string $resource = CustomPermissionResource::class;
}
