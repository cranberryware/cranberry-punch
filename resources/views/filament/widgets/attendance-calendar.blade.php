<x-filament::widget 
:attributes="\Filament\Support\prepare_inherited_attributes($xattributes)->merge(['class'=>'filament-widgets-table-widget oa-attendance-calendar-widget'])"
:extra-attributes="$xattributes"
:new-attributes="$newAttributes"
>
{{$this->inside_hac_p}}

    {{ $this->table }}
</x-filament::widget>
