<?php

namespace App\Filament\Resources\DesignationResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DesignationResource;
use App\Helpers\Helper\Helper;
use Filament\Pages\Actions\Action;

class CreateDesignation extends CreateRecord
{
    protected static string $resource = DesignationResource::class;

    protected function getRedirectUrl(): string
    {
        return Helper::getRedirectUrl($this);
    }

}
