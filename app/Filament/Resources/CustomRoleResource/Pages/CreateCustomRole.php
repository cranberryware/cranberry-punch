<?php

namespace App\Filament\Resources\CustomRoleResource\Pages;

use App\Filament\Resources\CustomRoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomRole extends CreateRecord
{
    protected static string $resource = CustomRoleResource::class;
}
