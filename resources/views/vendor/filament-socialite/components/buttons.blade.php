@if (count($providers))
    <div class="grid">
        @foreach ($providers as $key => $provider)
            <x-filament::button tag="a" :href="route('socialite.oauth.redirect', $key)" class="bg-transparent shadow-none"
                style="background-color: transparent !important; box-shadow: none">
                <div class="flex flex-row justify-center cursor-pointer items-center min-h-0">
                    <span class="mr-2 text-xl text-grayText font-semibold">Sign in with</span>
                    <img src="{{ url('assets/googleIcon.svg') }}" class="w-13 h-13" alt="image" />
                </div>

            </x-filament::button>
        @endforeach
    </div>
@else
    <span></span>
@endif
