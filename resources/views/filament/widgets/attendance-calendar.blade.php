<x-filament::widget class="filament-widgets-table-widget cp-attendance-calendar-widget  {{auth()->user()->hasRole(['employee']) ? 'attendence-calendar':''}} ">

{{ $this->table }}
 
</x-filament::widget>
