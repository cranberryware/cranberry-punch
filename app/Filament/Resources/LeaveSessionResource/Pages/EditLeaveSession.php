<?php

namespace App\Filament\Resources\LeaveSessionResource\Pages;

use App\Filament\Resources\LeaveSessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaveSession extends EditRecord
{
    protected static string $resource = LeaveSessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
