<?php

namespace App\Filament\Resources\LeaveSessionResource\Pages;

use App\Filament\Resources\LeaveSessionResource;
use App\Helpers\Helper\Helper;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLeaveSession extends CreateRecord
{
    protected static string $resource = LeaveSessionResource::class;

    protected function getRedirectUrl(): string
    {
        return Helper::getRedirectUrl($this);
    }
}
