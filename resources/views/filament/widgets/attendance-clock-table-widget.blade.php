<x-filament::widget class="filament-widgets-table-widget oa-attendance-clock-widget shadow-lg rounded-xl border  {{(auth()->user()->employee && auth()->user()->employee->clocked_out()) ? 'shadow-themePrimaryExtraLight border-green-400':'shadow-red-200 border-red-400'}}">
    {{ $this->table }}
</x-filament::widget>
