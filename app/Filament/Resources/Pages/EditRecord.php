<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\EditRecord as FilamentEditRecord;

class EditRecord extends FilamentEditRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
