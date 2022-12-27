@if (strpos($slot, 'Welcome') !== false)
    <p
        {{ $attributes->class(['filament-header-heading tracking-tight px-8 py-2.5 rounded-full bg-themePrimaryTitle']) }}>
        {{ $slot }}
    </p>
@else
    <p
        {{ $attributes->class(['filament-header-heading font-bold tracking-tight px-8 py-2 rounded-full bg-themePrimaryTitle uppercase text-lg']) }}>
        {{ $slot }}
    </p>
@endif
