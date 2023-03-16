<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLeaveRequest extends CreateRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['duration'] = self::getDuration($data['from'], $data['to']);
        $data['applied_on'] = Carbon::now();
        return $data;
    }

    public static function getDuration($from, $to)
    {
        $startDate = Carbon::parse($from);
        $endDate = Carbon::parse($to);

        $duration = $startDate->diff($endDate)->days;
        return $duration;
    }
}
