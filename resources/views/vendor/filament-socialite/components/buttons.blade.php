@if (count($providers))
    <div class="grid">
        @foreach ($providers as $key => $provider)
            <x-filament::button tag="a" :href="route('socialite.oauth.redirect', $key)" class="bg-transparent shadow-none" :color="$provider['backgroundColor'] ?? 'transparent'"
                style=" box-shadow: none;">
                <div class="flex flex-row justify-center cursor-pointer items-center min-h-0">
                    <span class="mr-2 text-xl text-{{ $provider['color'] ?? 'transparent' }} font-semibold">
                        {{ $provider['label'] ?? null }}
                    </span>
                    @isset($provider['icon'])
                        <x-filament::icon-button :icon="$provider['icon']" :color="$provider['iconColor'] ?? null" size='lg'
                            style="box-shadow: none !important;"
                            class="bg-{{$provider['iconBackgroundColor'] ?? 'transparent'}} btn-cmn" />
                    @endisset

                </div>

            </x-filament::button>
        @endforeach
    </div>
@else
    <span></span>
@endif
