<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord as FilamentCreateRecord;

class CreateRecord extends FilamentCreateRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
