<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;
use App\Filament\Resources\Pages\CreateRecord;
use App\Helpers\Helper\Helper;
use Filament\Pages\Actions\Action;


class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function getRedirectUrl(): string
    {
        return Helper::getRedirectUrl($this);
    }

}
