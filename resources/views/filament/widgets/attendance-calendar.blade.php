<x-filament::widget class="filament-widgets-table-widget oa-attendance-calendar-widget border border-green-400 rounded-xl {{auth()->user()->hasRole(['employee']) ? 'attendence-calendar':''}} ">
    {{ $this->table }}
</x-filament::widget>
