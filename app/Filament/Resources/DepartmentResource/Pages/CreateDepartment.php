<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;
use App\Filament\Resources\Pages\CreateRecord;
use Filament\Pages\Actions;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;
}
