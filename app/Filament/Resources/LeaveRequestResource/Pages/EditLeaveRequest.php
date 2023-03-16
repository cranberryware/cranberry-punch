<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaveRequest extends EditRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['duration'] = self::getDuration($data['from'], $data['to']);
        return $data;
    }

    public static function getDuration($from, $to)
    {
        $startDate = Carbon::parse($from);
        $endDate = Carbon::parse($to);

        $duration = $startDate->diff($endDate)->days;
        return $duration;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
