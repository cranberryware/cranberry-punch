<?php

namespace App\Filament\Pages;

use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class AttendanceKiosk extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected static string $view = 'filament.pages.attendance-kiosk';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('open-attendance::open-attendance.section.group-attendance-management'));
    }

    public static function getNavigationLabel(): string
    {
        return strval(__('open-attendance::open-attendance.section.attendance-kiosk.label'));
    }

    public function getTitle(): string
    {
        return strval(__('open-attendance::open-attendance.section.attendance-kiosk.title'));
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can("clock attendances") && auth()->user()->employee;
    }

    protected function getActions(): array
    {
        return [
            Action::make('attendance_clock')
                ->label(function (): string {
                    return (auth()->user()->employee->clocked_out())
                        ? __('open-attendance::open-attendance.attendance-kiosk.button.clock-in')
                        : __('open-attendance::open-attendance.attendance-kiosk.button.clock-out');
                })
                ->icon(function (): string {
                    return (auth()->user()->employee->clocked_out())
                        ? 'heroicon-o-login'
                        : 'heroicon-o-logout';
                })
                ->color(function (): string {
                    return (auth()->user()->employee->clocked_out())
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
