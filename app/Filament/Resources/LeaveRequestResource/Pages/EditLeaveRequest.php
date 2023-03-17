<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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

    protected function afterSave(): void
    {
        if ($this->record->id && $this->record->status == 'approved') {
            $total_allowance = $this->record->leaveType->total_allowance;
            $designation = $this->record->employee->designation->name;

            // Convert the array to a Laravel Collection
            $collection = Collection::make($total_allowance);

            // Filter the collection to find the desired object
            $filtered = $collection->where('designation', $designation);

            // Extract the number_of_allowance value from the filtered object
            $number_of_allowance = $filtered->pluck('number_of_allowance')->first();

            //check the employee_id, leave_type_id and leave_session_id in LeaveBalance model.
            $leaveBalance =  LeaveBalance::where(['employee_id'=> $this->record->employee_id, 'leave_type_id' => $this->record->leave_type_id, 'leave_session_id' => $this->record->leave_session_id])->first();
            if ($leaveBalance) {
                //update
                $leaveBalance->used = $leaveBalance->used + $this->record->duration;
                $leaveBalance->available = $leaveBalance->available - $this->record->duration;
                $leaveBalance->save();
            } else {
               //create
               $leaveBalance = new LeaveBalance();
               $leaveBalance->employee_id = $this->record->employee_id;
               $leaveBalance->leave_type_id = $this->record->leave_type_id;
               $leaveBalance->leave_session_id = $this->record->leave_session_id;
               $leaveBalance->used = $this->record->duration;
               $leaveBalance->available = $number_of_allowance - $this->record->duration;
               $leaveBalance->save();
            }
        }
    }
}
