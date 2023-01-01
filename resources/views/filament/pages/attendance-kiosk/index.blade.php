@props([
    'actions' => null,
])
<x-filament::page>
    <x-filament::pages.actions :actions="$actions" class="shrink-0" />
</x-filament::page>
