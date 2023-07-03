<?php

namespace App\Filament\Resources\LeaveSessionResource\Pages;

use App\Filament\Resources\LeaveSessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveSessions extends ListRecords
{
    protected static string $resource = LeaveSessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
