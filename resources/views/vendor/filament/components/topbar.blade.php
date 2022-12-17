@props([
    'breadcrumbs' => [],
])
<div class="flex w-full items-center ">
    <div class="rounded-full flex items-center justify-center h-[88px] w-[91px] bg-[#F1F1F1] ml-5 mt-4 flex-none">
        {!! file_get_contents('images/cp_logo_sm.svg') !!}
       </div> 
    <header {{ $attributes->class([
        'filament-main-topbar sticky top-0 z-10 flex max-w-6xl shrink-0 items-center border-b mr-6 bg-white',
        'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
    ]) }}>
       @if (config('filament.layout.sidebar.is_collapsible_on_desktop'))
       <button
           type="button"
           class="filament-sidebar-close-button shrink-0 flex items-center justify-center w-10 h-10 text-primary-500 rounded-full hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none"
           x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' : '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
           x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
           x-show="(! $store.sidebar.isOpen) && @js(config('filament.layout.sidebar.collapsed_width') !== 0)"
           x-transition:enter="lg:transition delay-100"
           x-transition:enter-start="opacity-0"
           x-transition:enter-end="opacity-100"
       >
           {{-- <svg class="w-10 h-10 mr-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
           </svg> --}}
           {{-- <div class="rounded-full flex items-center justify-center h-[88px] w-[91px] bg-[#F1F1F1] ml-5 mt-3">
            {!! file_get_contents('images/cp_logo_sm.svg') !!}
           </div>  --}}
       </button>
       @endif
    
       <div class="flex items-center px-2 sm:px-4 md:px-6 lg:px-8 cp-topbar-main">
        <button
            x-cloak
            x-data="{}"
            x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' : '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
            x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
            @class([
                'filament-sidebar-open-button shrink-0 flex items-center justify-center w-10 h-10 text-primary-500 rounded-full hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none',
                'lg:mr-4 rtl:lg:mr-0 rtl:lg:ml-4' => config('filament.layout.sidebar.is_collapsible_on_desktop'),
                'lg:hidden' => ! (config('filament.layout.sidebar.is_collapsible_on_desktop') && (config('filament.layout.sidebar.collapsed_width') === 0)),
            ])
        >
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
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
    
</div>
