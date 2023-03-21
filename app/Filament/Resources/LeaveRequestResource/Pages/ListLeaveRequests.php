<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use App\Filament\Resources\LeaveRequestResource\Widgets\LeaveRequestStatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveRequests extends ListRecords
{
    protected static string $resource = LeaveRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Leave Apply'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // LeaveRequestStatsOverview::class,
        ];
    }
}
