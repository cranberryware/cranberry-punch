@props([
    'title' => null,
    'width' => 'md',
])

<x-filament::layouts.base :title="$title">
    <div @class([
        'flex items-center min-h-[842px] py-12 text-gray-900 bg-white',
        'dark:bg-gray-900 dark:text-white' => config('filament.dark_mode'),
    ])>
        <div @class([
            'w-screen px-6 space-y-8 md:mt-0 md:px-2 border-solid ml-80',
            match($width) {
                'xs' => 'max-w-xs',
                'sm' => 'max-w-sm',
                'md' => 'max-w-md',
                'lg' => 'max-w-lg',
                'xl' => 'max-w-xl',
                '2xl' => 'max-w-2xl',
                '3xl' => 'max-w-3xl',
                '4xl' => 'max-w-4xl',
                '5xl' => 'max-w-5xl',
                '6xl' => 'max-w-6xl',
                '7xl' => 'max-w-7xl',
                default => $width,
            },
        ])>
        <div class="flex ml-40">
            <div class="whitespace-nowrap text-[20px] ml-2 font-[500] font-[sans-serif] text-[#565656]">
                Sign in with
            </div>
            <div class="ml-4 -mt-3">
                {!! file_get_contents('images/google.svg') !!}
            </div>
        </div>
        <div class="block ml-[16rem]">
            <div class="text-[20px] font-[500] font-[sans-serif] text-[#565656]">
                or
            </div>
        </div>

            <div @class([
                'p-8 space-y-4 bg-white/50 backdrop-blur-xl rounded-2xl',
                'dark:bg-gray-900/50 dark:border-gray-700' => config('filament.dark_mode'),
            ])>

                <div {{ $attributes }}>
                    {{ $slot }}
                </div>
            </div>
        </div>
        <div class="place-items-center flex ml-40 -mt-[12rem]">
            <img src="/images/Vector.png" alt="hgdhsgg">
        </div>
    </div>
    <div class="bg-[#059669] h-[22px] w-full"/>
    
    @livewire('notifications')
</x-filament::layouts.base>
