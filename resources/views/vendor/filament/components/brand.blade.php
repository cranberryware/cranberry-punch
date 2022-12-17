@if (filled($brand = config('filament.brand')))
    <div @class([
        'filament-brand text-xl font-bold tracking-tight',
        'dark:text-white' => config('filament.dark_mode'),
    ])>
        <div class="h-[88px] w-[245px] flex justify-center items-center bg-[#F1F1F1] rounded-full">
            {!! file_get_contents('images/sidebarLogo.svg') !!}
        </div>
    </div>
@endif
