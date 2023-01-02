<x-filament::widget class="filament-widgets-table-widget attendanceClock cp-attendance-clock-widget shadow-lg  hover:rounded-2xl  {{(auth()->user()->employee && auth()->user()->employee->clocked_out()) ? 'shadow-green-350 border-green-400':'shadow-red-200 border-red-400'}}">
    {{ $this->table }}
</x-filament::widget>
