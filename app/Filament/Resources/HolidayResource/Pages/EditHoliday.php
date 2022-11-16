<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
