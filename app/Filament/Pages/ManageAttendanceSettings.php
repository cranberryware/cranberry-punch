<?php

namespace App\Filament\Pages;

use App\Rules\IpAddress;
use App\Rules\Slug;
use App\Enums\CheckInMode;
use Filament\Pages\SettingsPage;
use App\Settings\AttendanceSettings;
use App\Support\Str;
use Closure;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Pages\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use HappyToDev\FilamentTailwindColorPicker\Forms\Components\TailwindColorPicker;

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
        return strval(__('cranberry-punch::cranberry-punch.section.group-cranberry-punch-settings'));
    }

    public static function getLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings'));
    }

    public static function getNavigationLabel(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings'));
    }

    public function getTitle(): string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings'));
    }

    protected function getFormSchema(): array
    {
        return
            [
                Grid::make(1)
                    ->schema([
                        Tabs::make('punch-settings')
                            ->tabs([
                                Tab::make(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings.location'))
                                    ->schema([
                                        Repeater::make('ip_locations')
                                            ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.ip-locations'))
                                            ->schema([
                                                TextInput::make('ip')
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.ip-locations.ip'))
                                                    ->rules([new IpAddress()])
                                                    ->required(),
                                                TextInput::make('location')
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.ip-locations.location'))
                                                    ->rules([new Slug()])
                                                    ->required(),
                                            ])
                                            ->itemLabel(fn (array $state): ?string => "{$state['ip']} - {$state['location']}" ?? null)
                                            ->columns(2)
                                            ->defaultItems(1)
                                            ->minItems(1)
                                            ->maxItems(25)
                                            ->orderable(true),

                                    ]),
                                Tab::make(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings.calendar-cell-colors'))
                                    ->schema([
                                        Repeater::make('calendar_cell_colors')
                                            ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.calendar-cell-colors'))
                                            ->schema([
                                                TextInput::make('max_value')
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.calendar-cell-colors.max_value'))
                                                    ->numeric()
                                                    ->step(0.1)
                                                    ->minValue(0)
                                                    ->maxValue(24)
                                                    ->required(),
                                                TailwindColorPicker::make('background_color')
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.calendar-cell-colors.cell-background-color'))
                                                    ->bgScope()
                                                    ->required(),
                                                TagsInput::make('extra_css_classes')
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.calendar-cell-colors.extra-css-classes'))
                                                    ->placeholder(__('cranberry-punch::cranberry-punch.section.cranberry-punch.placeholder.calendar-cell-colors.extra-css-classes')),
                                            ])
                                            ->itemLabel(fn (array $state): ?string => "" ?? null)
                                            ->columns(3)
                                            ->defaultItems(1)
                                            ->minItems(1)
                                            ->maxItems(25)
                                            ->orderable(true),
                                    ]),
                                Tab::make(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings.weekly-day-offs'))
                                    ->schema([
                                        CheckboxList::make('weekly_day_offs')
                                            ->extraAttributes([
                                                'class' => 'custom-cl'
                                            ])
                                            ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.weekly-day-offs'))
                                            ->options(function () {
                                                $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                                                $indexes = [
                                                    "First" => "1st",
                                                    "Second" => "2nd",
                                                    "Third" => "3rd",
                                                    "Fourth" => "4th",
                                                    "Fifth" => "5th"
                                                ];
                                                $options = [];
                                                foreach ($indexes as $index => $index_num) {
                                                    foreach ($days as $day) {
                                                        $options["{$index} {$day}"] = "{$index_num} {$day} of Month";
                                                    }
                                                }
                                                return $options;
                                            })
                                            ->columns(5)
                                            ->required(),
                                    ]),
                                    Tab::make(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings.holiday_types'))
                                    ->schema([
                                        Repeater::make('holiday_types')
                                            ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.holiday_type'))
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.holiday_type.name'))
                                                    ->reactive()
                                                    ->afterStateUpdated(function (Closure $set, $state) {
                                                        $set('slug', Str::slug($state));
                                                    })->required(),
                                                TextInput::make('slug')
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.holiday_type.slug'))
                                                    ->required(),
                                                TailwindColorPicker::make('holiday_color')
                                                    ->bgScope()
                                                    ->label(__('cranberry-punch::cranberry-punch.section.cranberry-punch.input.holiday_type.holiday_color'))
                                                    ->required()
                                            ])
                                            ->defaultItems(1)
                                            ->columns(3)
                                    ]),
                                    Tab::make(__('cranberry-punch::cranberry-punch.section.cranberry-punch-attendance-settings.miscellaneous'))
                                    ->schema([
                                        Select::make('default_check_in_mode')
                                            ->default(null)
                                            ->options(CheckInMode::getModes()),
                                        Select::make('check_in_mode_override')
                                            ->default(null)
                                            ->options(CheckInMode::getModes()),
                                    ]),
                            ])
                            ->activeTab(1)
                    ])

            ];
    }
}
