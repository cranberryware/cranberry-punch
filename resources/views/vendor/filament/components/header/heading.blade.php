@if (strpos($slot, 'Welcome') !== false)
    <p
        {{ $attributes->class(['filament-header-heading tracking-tight px-8 py-2.5 rounded-full bg-green-150']) }}>
        {{ $slot }}
    </p>
@else
    <p
        {{ $attributes->class(['filament-header-heading font-bold tracking-tight px-8 py-2 rounded-full bg-green-150 uppercase text-lg']) }}>
        {{ $slot }}
    </p>
@endif
