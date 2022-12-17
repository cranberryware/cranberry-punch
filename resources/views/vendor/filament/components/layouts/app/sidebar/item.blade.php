@props([
    'active' => false,
    'activeIcon',
    'badge' => null,
    'badgeColor' => null,
    'icon',
    'shouldOpenUrlInNewTab' => false,
    'url',
    'label',
])

<li @class([
    'filament-sidebar-item overflow-hidden ',
    'pl-6' => $label == 'Dashboard',
    'pl-8 border border-l-0 border-themePrimary' => $label != 'Dashboard',
    'filament-sidebar-item-active ' => $active,
    'text-white active-nav' => $active && $label != 'Dashboard',
    'hover:bg-themePrimaryDark hover:rounded-r-full hover:border-themePrimaryLight_2 hover:border hover:border-l-0
        focus:bg-themePrimaryDark focus:rounded-r-full focus:border-themePrimaryLight_2 focus:border focus:border-l-0' =>
        !$active && $label != 'Dashboard',
]) @if (config('filament.layout.sidebar.is_collapsible_on_desktop'))
    x-bind:class="$store.sidebar.isOpen ? '' : 'pl-0'"
    @endif
    >
    <a href="{{ $url }}" {!! $shouldOpenUrlInNewTab ? 'target="_blank"' : '' !!}
        x-on:click="window.matchMedia(`(max-width: 1024px)`).matches && $store.sidebar.close()"
        @if (config('filament.layout.sidebar.is_collapsible_on_desktop')) x-data="{ tooltip: {} }"
            x-init="
                Alpine.effect(() => {
                    if (Alpine.store('sidebar').isOpen) {
                        tooltip = false
                    } else {
                        tooltip = {
                            content: {{ \Illuminate\Support\Js::from($slot->toHtml()) }},
                            theme: Alpine.store('theme') === 'light' ? 'dark' : 'light',
                            placement: document.dir === 'rtl' ? 'left' : 'right',
                        }
                    }
                })
            "
            x-tooltip.html="tooltip" @endif
        @class([
            'flex items-center justify-center gap-3 px-3 py-2 rounded-lg font-medium transition' =>
                $label != 'Dashboard',

            'dark:text-gray-300 dark:hover:bg-gray-700' =>
                !$active && config('filament.dark_mode'),

            ' uppercase text-[16px] flex items-center justify-center gap-3 px-3 py-2  font-medium transition' =>
                $label == 'Dashboard',
        ])>
        <x-dynamic-component :component="$active && $activeIcon ? $activeIcon : $icon" class="h-6 w-6 shrink-0" />

        <div class="flex flex-1" @if (config('filament.layout.sidebar.is_collapsible_on_desktop')) x-show="$store.sidebar.isOpen" @endif>
            <span>
                {{ $slot }}
            </span>
        </div>

        @if (filled($badge))
            <x-filament::layouts.app.sidebar.badge :badge="$badge" :badge-color="$badgeColor" :active="$active" />
        @endif
    </a>
</li>
