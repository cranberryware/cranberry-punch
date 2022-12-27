<x-filament::widget class="filament-widgets-table-widget oa-attendance-calendar-widget  {{auth()->user()->hasRole(['employee']) ? 'attendence-calendar':''}} ">
    {{ $this->table }}
</x-filament::widget>
