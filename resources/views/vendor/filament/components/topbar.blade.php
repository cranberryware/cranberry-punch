@props([
    'breadcrumbs' => [],
])

<header
    {{ $attributes->class([
        'filament-main-topbar sticky top-0 z-10 flex h-[6rem] w-full shrink-0 items-center bg-white',
        'dark:bg-gray-800 ' => config('filament.dark_mode'),
    ]) }}>
    <div x-show="(! $store.sidebar.isOpen) && @js(config('filament.layout.sidebar.collapsed_width') !== 0)">
        <img src="{{ url('assets/minIcon.svg') }}" />
    </div>
    <div class="flex items-center w-full px-2 sm:px-4 md:px-6 lg:px-8 border rounded-full py-4 mr-6 ml-2 mt-1 bg-gray-30">
        <button x-cloak x-data="{}"
            x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' :
                '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
            x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
            @class([
                'filament-sidebar-open-button shrink-0 flex items-center justify-center w-10 h-10 text-primary-500 rounded-full hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none',
                'lg:mr-4 rtl:lg:mr-0 rtl:lg:ml-4' => config(
                    'filament.layout.sidebar.is_collapsible_on_desktop'
                ),
                'lg:hidden' => !(
                    config('filament.layout.sidebar.is_collapsible_on_desktop') &&
                    config('filament.layout.sidebar.collapsed_width') === 0
                ),
            ])>
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <div class="flex items-center justify-between flex-1">
            <x-filament::layouts.app.topbar.breadcrumbs :breadcrumbs="$breadcrumbs" />

            @livewire('filament.core.global-search')

            @livewire('filament.core.notifications')

            <x-filament::layouts.app.topbar.user-menu />
        </div>
    </div>
</header>
