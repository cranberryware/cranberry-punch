<?php

namespace App\Filament\Resources\DesignationResource\Pages;

use App\Filament\Resources\DesignationResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use App\Filament\Resources\Pages\EditRecord;

class EditDesignation extends EditRecord
{
    protected static string $resource = DesignationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
