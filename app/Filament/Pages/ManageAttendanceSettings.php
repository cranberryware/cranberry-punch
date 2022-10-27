<?php

namespace App\Filament\Pages;

use App\Rules\IpAddress;
use App\Rules\Slug;
use Filament\Pages\SettingsPage;
use App\Settings\AttendanceSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class ManageAttendanceSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?int $navigationSort = 50;

    protected static string $settings = AttendanceSettings::class;

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        if (!auth()->user()->can("manage attendance settings")) {
            abort(403);
            return;
        }
        parent::mount();
    }

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

    public static function getNavigationLabel(): string
    {
        return strval(__('open-attendance::open-attendance.section.open-attendance-attendance-settings'));
    }

    public function getTitle(): string
    {
        return strval(__('open-attendance::open-attendance.section.open-attendance-attendance-settings'));
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make(__('open-attendance::open-attendance.section.open-attendance-attendance-settings.location'))
                ->schema([
                    Repeater::make('ip_locations')
                        ->label(__('open-attendance::open-attendance.section.open-attendance.input.ip-locations'))
                        ->schema([
                            TextInput::make('ip')
                                ->label(__('open-attendance::open-attendance.section.open-attendance.input.ip-locations.ip'))
                                ->rules([new IpAddress()])
                                ->required(),
                            TextInput::make('location')
                                ->label(__('open-attendance::open-attendance.section.open-attendance.input.ip-locations.location'))
                                ->rules([new Slug()])
                                ->required(),
                        ])
                        ->itemLabel(fn (array $state): ?string => "{$state['ip']} - {$state['location']}" ?? null)
                        ->columns(2)
                        ->defaultItems(1)
                        ->minItems(1)
                        ->maxItems(25)
                        ->orderable(true),
                ])->collapsible(),
        ];
    }
}
