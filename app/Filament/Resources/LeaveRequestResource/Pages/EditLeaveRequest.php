<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Enums\LeaveRequestStatus;
use App\Filament\Resources\LeaveRequestResource;
use App\Helpers\Helper\Helper;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class EditLeaveRequest extends EditRecord
{
    protected static string $resource = LeaveRequestResource::class;

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $data['duration'] = self::getDuration($data['from'], $data['to']);
    //     return $data;
    // }

    // public static function getDuration($from, $to)
    // {
    //     $startDate = Carbon::parse($from);
    //     $endDate = Carbon::parse($to);

    //     $duration = $startDate->diff($endDate)->days;
    //     return $duration;
    // }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('approved')
                ->color('primary')
                ->visible(function () {
                    return ($this->record->status === LeaveRequestStatus::PENDING && (auth()->user()->hasRole(['hr-manager', 'super-admin']) || $this->record->manager_user_id === auth()->user()->id));
                })
                ->action(function () {
                    $newRecord = $this->record;
                    $newRecord->notes = $this->data['notes'];
                    $newRecord->status = LeaveRequestStatus::APPROVED()->value;
                    $newRecord->save();
                })
                ->requiresConfirmation(),
            Actions\Action::make('reject')
                ->color('danger')
                ->visible(function () {
                    return ($this->record->status === LeaveRequestStatus::PENDING && (auth()->user()->hasRole(['hr-manager', 'super-admin']) || $this->record->manager_user_id === auth()->user()->id));
                })
                ->action(function () {
                    $newRecord = $this->record;
                    $newRecord->notes = $this->data['notes'];
                    $newRecord->status = LeaveRequestStatus::REJECTED()->value;
                    $newRecord->save();
                })
                ->requiresConfirmation(),
            Actions\Action::make('cancel')
                ->color('warning')
                ->visible(function () {
                    return ($this->record->status === LeaveRequestStatus::PENDING && (auth()->user()->hasRole(['hr-manager', 'super-admin']) || $this->record->employee->user->id === auth()->user()->id));
                })
                ->action(function () {
                    $newRecord = $this->record;
                    $newRecord->notes = $this->data['notes'];
                    $newRecord->status = LeaveRequestStatus::REJECTED()->value;
                    $newRecord->save();
                })
                ->requiresConfirmation(),
        ];
    }

    // protected function getFormActions(): array
    // {

    //     return [
    //         Action::make('save')
    //             ->submit('save'),
    //         Action::make('cancel')
    //             ->url($this->previousUrl ?? static::getResource()::getUrl()),
    //         Action::make('accept')
    //             ->action(function () {
    //                 $newRecord = $this->record;
    //                 $newRecord->notes = $this->data['notes'];
    //                 $newRecord->status = LeaveRequestStatus::APPROVED()->value;
    //                 $newRecord->save();
    //             }),
    //         Action::make('reject')
    //             ->action(function () {
    //                 $newRecord = $this->record;
    //                 $newRecord->notes = $this->data['notes'];
    //                 $newRecord->status = LeaveRequestStatus::REJECTED()->value;
    //                 $newRecord->save();
    //             }),
    //         Action::make('canceled')
    //             ->action(function () {
    //                 $newRecord = $this->record;
    //                 $newRecord->notes = $this->data['notes'];
    //                 $newRecord->status = LeaveRequestStatus::CANCELLED()->value;
    //                 $newRecord->save();
    //             })

    //     ];
    // }

    // protected function afterSave(): void
    // {
    //     if ($this->record->id && $this->record->status == 'approved') {
    //         $total_allowance = $this->record->leaveType->total_allowance;
    //         $designation = $this->record->employee->designation->name;

    //         // Convert the array to a Laravel Collection
    //         $collection = Collection::make($total_allowance);

    //         // Filter the collection to find the desired object
    //         $filtered = $collection->where('designation', $designation);

    //         // Extract the number_of_allowance value from the filtered object
    //         $number_of_allowance = $filtered->pluck('number_of_allowance')->first();

    //         //check the employee_id, leave_type_id and leave_session_id in LeaveBalance model.
    //         $leaveBalance =  LeaveBalance::where(['employee_id' => $this->record->employee_id, 'leave_type_id' => $this->record->leave_type_id, 'leave_session_id' => $this->record->leave_session_id])->first();
    //         if ($leaveBalance) {
    //             //update
    //             $leaveBalance->used = $leaveBalance->used + $this->record->duration;
    //             $leaveBalance->available = $leaveBalance->available - $this->record->duration;
    //             $leaveBalance->save();
    //         } else {
    //             //create
    //             $leaveBalance = new LeaveBalance();
    //             $leaveBalance->employee_id = $this->record->employee_id;
    //             $leaveBalance->leave_type_id = $this->record->leave_type_id;
    //             $leaveBalance->leave_session_id = $this->record->leave_session_id;
    //             $leaveBalance->used = $this->record->duration;
    //             $leaveBalance->available = $number_of_allowance - $this->record->duration;
    //             $leaveBalance->save();
    //         }
    //     }
    // }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
