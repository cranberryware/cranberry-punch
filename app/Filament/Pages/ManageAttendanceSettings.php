<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Settings\AttendanceSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;

class ManageAttendanceSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'filament.pages.manage-attendance-settings';


    protected static ?int $navigationSort = 50;

    protected static string $settings = AttendanceSettings::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can("manage attendance settings");
    }

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('open-attendance::open-attendance.section.group-open-attendance-settings'));
    }

    public static function getLabel(): string
    {
        return strval(__('open-attendance::open-attendance.section.open-attendance-attendance-settings'));
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make(__('open-attendance::open-attendance.section.open-attendance-attendance-settings'))
                ->schema([
                    TagsInput::make('work_ips'),
                    // Repeater::make('work_ips')
                    //     ->schema([
                    //         TextInput::make('ip')->required(),
                    //         TextInput::make('tag')->required(),
                    //     ])
                    //     ->columns(2)
                    //     ->defaultItems(2)
                ])->collapsible(),
        ];
    }
}
