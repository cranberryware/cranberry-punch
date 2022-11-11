<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AttendanceCalendar;
use App\Filament\Widgets\AttendanceClock;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class AttendanceKiosk extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected static string $view = 'filament.pages.attendance-kiosk.index';

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

    public function mount(): void
    {
        if (!auth()->user()->can("clock attendances") || !auth()->user()->employee) {
            abort(403);
            return;
        }

        parent::mount();
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can("clock attendances") && auth()->user()->employee;
    }

    protected function getViewData(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AttendanceClock::class,
            AttendanceCalendar::class,
        ];
    }
}
