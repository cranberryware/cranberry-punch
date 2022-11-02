<?php

namespace App\Filament\Widgets;

use Filament\Pages\Concerns\HasActions;
use Filament\Pages\Actions\Action;
use Filament\Forms\Contracts\HasForms;

class AttendanceClock extends Widget
{
    use HasActions;
    protected static string $view = 'filament.widgets.attendance-clock';
    public $actions = [];


    public function mount(): void
    {
        $this->actions = $this->getActions();
        parent::mount();
    }

    protected function getActions(): array
    {
        return [
            Action::make('attendance_clock')
                ->label(function (): string {
                    return (auth()->user()->employee && auth()->user()->employee->clocked_out())
                        ? __('open-attendance::open-attendance.attendance-kiosk.button.clock-in')
                        : __('open-attendance::open-attendance.attendance-kiosk.button.clock-out');
                })
                ->icon(function (): string {
                    return (auth()->user()->employee && auth()->user()->employee->clocked_out())
                        ? 'heroicon-o-login'
                        : 'heroicon-o-logout';
                })
                ->color(function (): string {
                    return (auth()->user()->employee && auth()->user()->employee->clocked_out())
                        ? 'success'
                        : 'danger';
                })
                ->action(function () {
                    auth()->user()->employee->attendance_clock();
                })
                ->requiresConfirmation(),
        ];
    }
}
