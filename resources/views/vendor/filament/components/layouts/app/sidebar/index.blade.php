<aside x-data="{}"
    @if (config('filament.layout.sidebar.is_collapsible_on_desktop')) x-cloak
        x-bind:class="$store.sidebar.isOpen ? 'filament-sidebar-open translate-x-0 max-w-[20em] lg:max-w-[var(--sidebar-width)]' : '-translate-x-full lg:translate-x-0 lg:max-w-[var(--collapsed-sidebar-width)] rtl:lg:-translate-x-0 rtl:translate-x-full'"
    @else
        x-cloak="-lg"
        x-bind:class="$store.sidebar.isOpen ? 'filament-sidebar-open translate-x-0' : '-translate-x-full lg:translate-x-0 rtl:lg:-translate-x-0 rtl:translate-x-full'" @endif
    @class([
        'filament-sidebar fixed inset-y-0 left-0 rtl:left-auto rtl:right-0 z-20 flex flex-col h-screen overflow-hidden shadow-2xl transition-all bg-white lg:border-r rtl:lg:border-r-0 rtl:lg:border-l w-[var(--sidebar-width)] lg:z-0',
        'lg:translate-x-0' => !config(
            'filament.layout.sidebar.is_collapsible_on_desktop'
        ),
        'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
    ])>
    <header @class([
        'filament-sidebar-header h-[6rem] shrink-0 flex items-center bg-green-750 ',
        '' => config('filament.dark_mode'),
    ])>
        <div @class([
            'flex items-center justify-center px-6 mt-2 w-full bg-gradient-to-r from-green-650',
            'lg:px-3' =>
                config('filament.layout.sidebar.is_collapsible_on_desktop') &&
                config('filament.layout.sidebar.collapsed_width') !== 0,
        ]) x-show="$store.sidebar.isOpen || @js(!config('filament.layout.sidebar.is_collapsible_on_desktop')) || @js(config('filament.layout.sidebar.collapsed_width') === 0)">
            @if (config('filament.layout.sidebar.is_collapsible_on_desktop') &&
                config('filament.layout.sidebar.collapsed_width') !== 0)
                <button type="button"
                    class="filament-sidebar-collapse-button shrink-0 hidden lg:flex items-center justify-center w-10 h-10 text-white rounded-full hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none"
                    x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' :
                        '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
                    x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                    x-transition:enter="lg:transition delay-100" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100">
                    <img src="{{ url('assets/closeMenu.svg') }}" />
                </button>
            @endif

            <a href="{{ config('filament.home_url') }}" data-turbo="false" @class([
                'block w-full',
                'lg:ml-3 px-4' =>
                    config('filament.layout.sidebar.is_collapsible_on_desktop') &&
                    config('filament.layout.sidebar.collapsed_width') !== 0,
            ])>
                {{-- <x-filament::brand /> --}}
                <img src="{{ url('assets/topBarIcon.svg') }}" />
            </a>
        </div>

        @if (config('filament.layout.sidebar.is_collapsible_on_desktop'))
            <div @class([
                'border-y flex border-r rounded-r-full bg-green-650 border-green-650 w-full mr-3 py-4 justify-center' => config(
                    'filament.layout.sidebar.is_collapsible_on_desktop'
                ),
            ]) x-show="(! $store.sidebar.isOpen) && @js(config('filament.layout.sidebar.collapsed_width') !== 0)">
                <button type="button"
                    class="filament-sidebar-close-button shrink-0 flex items-center justify-center w-10 h-10 text-white rounded-full hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none"
                    x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' :
                        '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
                    x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                    x-show="(! $store.sidebar.isOpen) && @js(config('filament.layout.sidebar.collapsed_width') !== 0)" x-transition:enter="lg:transition delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <img src="{{ url('assets/openMenu.svg') }}" />
                </button>
            </div>
        @endif
    </header>

    <nav class="flex-1 py-6 overflow-x-hidden overflow-y-auto filament-sidebar-nav">
        <x-filament::layouts.app.sidebar.start />
        {{ \Filament\Facades\Filament::renderHook('sidebar.start') }}

        @php
            $navigation = \Filament\Facades\Filament::getNavigation();

            $collapsedNavigationGroupLabels = collect($navigation)
                ->filter(fn(\Filament\Navigation\NavigationGroup $group): bool => $group->isCollapsed())
                ->map(fn(\Filament\Navigation\NavigationGroup $group): string => $group->getLabel())
                ->values();
        @endphp

        <script>
            if (localStorage.getItem('collapsedGroups') === null) {
                localStorage.setItem('collapsedGroups', JSON.stringify(@js($collapsedNavigationGroupLabels)))
            }
        </script>

        <ul class="space-y-6"
            @if (config('filament.layout.sidebar.is_collapsible_on_desktop')) x-bind:class="$store.sidebar.isOpen ? 'pr-6' : 'pr-3'" @endif>
            @foreach ($navigation as $group)
                <x-filament::layouts.app.sidebar.group :label="$group->getLabel()" :icon="$group->getIcon()" :collapsible="$group->isCollapsible()"
                    :items="$group->getItems()" />

                {{-- @if (!$loop->last)
                    <li>
                        <div @class([
                            'border-t -mr-6 rtl:-mr-auto rtl:-ml-6',
                            'dark:border-gray-700' => config('filament.dark_mode'),
                        ])></div>
                    </li>
                @endif --}}
            @endforeach
        </ul>

        <x-filament::layouts.app.sidebar.end />
        {{ \Filament\Facades\Filament::renderHook('sidebar.end') }}
    </nav>

    <x-filament::layouts.app.sidebar.footer />
</aside>
