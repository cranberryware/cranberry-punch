<aside
    x-data="{}"
    @if (config('filament.layout.sidebar.is_collapsible_on_desktop'))
        x-cloak
        x-bind:class="$store.sidebar.isOpen ? 'filament-sidebar-open translate-x-0 max-w-[20em] lg:max-w-[var(--sidebar-width)] bg-[#059669]' : '-translate-x-full lg:translate-x-0 lg:max-w-[var(--collapsed-sidebar-width)] rtl:lg:-translate-x-0 rtl:translate-x-full'"
    @else
        x-cloak="-lg"
        x-bind:class="$store.sidebar.isOpen ? 'filament-sidebar-open translate-x-0' : '-translate-x-full lg:translate-x-0 rtl:lg:-translate-x-0 rtl:translate-x-full'"
    @endif
    @class([
        'filament-sidebar fixed inset-y-0 left-0 rtl:left-auto rtl:right-0 z-20 flex flex-col h-screen overflow-hidden shadow-2xl transition-all bg-white lg:border-r rtl:lg:border-r-0 rtl:lg:border-l w-[var(--sidebar-width)] lg:z-0',
        'lg:translate-x-0' => ! config('filament.layout.sidebar.is_collapsible_on_desktop'),
        'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
    ])
>
    <header @class([
        'filament-sidebar-header shrink-0 flex  items-center justify-center relative bg-[#059669]' ,
        'dark:border-gray-700' => config('filament.dark_mode'),
    ])>
        <div
            @class([
                'flex items-center justify-center pl-[3.3rem] w-[97%] bg-[#007C56] h-[88px] mt-[20px] rounded-r-full mr-[11px]',
                'lg:px-4' => config('filament.layout.sidebar.is_collapsible_on_desktop') && (config('filament.layout.sidebar.collapsed_width') !== 0),
            ])
            x-show="$store.sidebar.isOpen || @js(! config('filament.layout.sidebar.is_collapsible_on_desktop')) || @js(config('filament.layout.sidebar.collapsed_width') === 0)"
        >
        @if (config('filament.layout.sidebar.is_collapsible_on_desktop') && (config('filament.layout.sidebar.collapsed_width') !== 0))
        <button
            type="button"
            class="filament-sidebar-collapse-button ml-3 shrink-0 hidden lg:flex items-center justify-center w-10 h-10 text-primary-500 rounded-full hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none text-[#ffffff]"
            x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' : '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
            x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
            x-transition:enter="lg:transition delay-100"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        >
        <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.04471 6.37979C8.71418 7.04926 8.71418 8.13468 8.04471 8.80415L4.84873 12.0001L8.04471 15.1961C8.71418 15.8656 8.71418 16.951 8.04471 17.6205C7.37524 18.29 6.28982 18.29 5.62035 17.6205L0 12.0001L5.62035 6.37979C6.28982 5.71032 7.37524 5.71032 8.04471 6.37979Z" fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.17944 1.71429C2.17944 0.767512 2.94696 0 3.89373 0H24.4652C25.4119 0 26.1794 0.767512 26.1794 1.71429C26.1794 2.66106 25.4119 3.42857 24.4652 3.42857H3.89373C2.94696 3.42857 2.17944 2.66106 2.17944 1.71429Z" fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.52637 11.9999C9.52637 11.0532 10.2939 10.2856 11.2407 10.2856H24.4651C25.4119 10.2856 26.1794 11.0532 26.1794 11.9999C26.1794 12.9467 25.4119 13.7142 24.4651 13.7142H11.2407C10.2939 13.7142 9.52637 12.9467 9.52637 11.9999Z" fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.17944 22.2858C2.17944 21.339 2.94696 20.5715 3.89373 20.5715H24.4652C25.4119 20.5715 26.1794 21.339 26.1794 22.2858C26.1794 23.2326 25.4119 24.0001 24.4652 24.0001H3.89373C2.94696 24.0001 2.17944 23.2326 2.17944 22.2858Z" fill="white"/>
            </svg>
        </button>
    @endif

            <a
                href="{{ config('filament.home_url') }}"
                data-turbo="false"
                @class([
                    'block w-full',
                    'lg:ml-3' => config('filament.layout.sidebar.is_collapsible_on_desktop') && (config('filament.layout.sidebar.collapsed_width') !== 0),
                ])
            >
                <x-filament::brand />
            </a>
        </div>

        @if (config('filament.layout.sidebar.is_collapsible_on_desktop'))
        <div class="flex items-center justify-center w-full bg-[#007C56] h-[88px] mt-[20px] rounded-r-full bg-[#007C56]">
            <button
            type="button"
            class="cp-sidebar-close-btn filament-sidebar-close-button shrink-0 flex items-center justify-center w-10 h-10 text-primary-500 hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none text-[#ffffff]"
            x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' : '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
            x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
            x-show="(! $store.sidebar.isOpen) && @js(config('filament.layout.sidebar.collapsed_width') !== 0)"
            x-transition:enter="lg:transition delay-100"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        >
            <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.135 6.37979C17.4655 7.04926 17.4655 8.13468 18.135 8.80415L21.331 12.0001L18.135 15.1961C17.4655 15.8656 17.4655 16.951 18.135 17.6205C18.8044 18.29 19.8899 18.29 20.5593 17.6205L26.1797 12.0001L20.5593 6.37979C19.8899 5.71032 18.8044 5.71032 18.135 6.37979Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 1.71429C24 0.767512 23.2325 0 22.2857 0H1.71428C0.767511 0 0 0.767512 0 1.71429C0 2.66106 0.767511 3.42857 1.71428 3.42857H22.2857C23.2325 3.42857 24 2.66106 24 1.71429Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6533 11.9999C16.6533 11.0532 15.8858 10.2856 14.939 10.2856H1.71455C0.767774 10.2856 0.000261307 11.0532 0.000261307 11.9999C0.000261307 12.9467 0.767774 13.7142 1.71455 13.7142H14.939C15.8858 13.7142 16.6533 12.9467 16.6533 11.9999Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 22.2858C24 21.339 23.2325 20.5715 22.2857 20.5715H1.71428C0.767511 20.5715 0 21.339 0 22.2858C0 23.2326 0.767511 24.0001 1.71428 24.0001H22.2857C23.2325 24.0001 24 23.2326 24 22.2858Z" fill="white"/>
                </svg>

        </button>
        </div>
            
        @endif
    </header>

    <nav class="flex-1 py-6 overflow-x-hidden overflow-y-auto filament-sidebar-nav bg-[#289965] text-[#ffffff]">
        <x-filament::layouts.app.sidebar.start />
        {{ \Filament\Facades\Filament::renderHook('sidebar.start') }}

        @php
            $navigation = \Filament\Facades\Filament::getNavigation();

            $collapsedNavigationGroupLabels = collect($navigation)
                ->filter(fn (\Filament\Navigation\NavigationGroup $group): bool => $group->isCollapsed())
                ->map(fn (\Filament\Navigation\NavigationGroup $group): string => $group->getLabel())
                ->values();
        @endphp

        <script>
            if (localStorage.getItem('collapsedGroups') === null) {
                localStorage.setItem('collapsedGroups', JSON.stringify(@js($collapsedNavigationGroupLabels)))
            }
        </script>

        <ul class="pl-3 pr-6 space-y-6">
            @foreach ($navigation as $group)
                <x-filament::layouts.app.sidebar.group
                    :label="$group->getLabel()"
                    :icon="$group->getIcon()"
                    :collapsible="$group->isCollapsible()"
                    :items="$group->getItems()"
                />
            @endforeach
        </ul>

        <x-filament::layouts.app.sidebar.end />
        {{ \Filament\Facades\Filament::renderHook('sidebar.end') }}
    </nav>

    <x-filament::layouts.app.sidebar.footer />
</aside>
