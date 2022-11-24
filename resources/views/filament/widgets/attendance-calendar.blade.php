<x-filament::widget 
:attributes="\Filament\Support\prepare_inherited_attributes($xattributes)->merge(['class'=>'filament-widgets-table-widget oa-attendance-calendar-widget'])"

>
    {{ $this->table }}
</x-filament::widget>
