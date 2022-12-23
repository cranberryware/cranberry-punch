<x-filament::widget class="filament-widgets-table-widget oa-attendance-calendar-widget border border-green-400 rounded-xl calender-view {{auth()->user()->roles[0]->id == 3 ? 'attendence-calendar':''}} ">
    {{ $this->table }}
</x-filament::widget>
