@props([
    'actions' => null,
    'heading',
    'subheading' => null,
])

@php
    $user = \Filament\Facades\Filament::auth()->user();
@endphp

<header
    {{ $attributes->class(['filament-header space-y-2 sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4']) }}>
    <div>
        <x-filament::header.heading>
            {{ $heading }}
        </x-filament::header.heading>

        {{-- @if ($subheading)
            <x-filament::header.subheading class="mt-1">
                {{ $subheading }}
            </x-filament::header.subheading>
        @endif --}}
    </div>

    @if ($heading == 'Dashboard')
        <x-filament::header.heading>
            Welcome, {{ \Filament\Facades\Filament::getUserName($user) }} to Cranberry Punch
        </x-filament::header.heading>
    @endif

    <x-filament::pages.actions :actions="$actions" class="shrink-0" />
</header>
