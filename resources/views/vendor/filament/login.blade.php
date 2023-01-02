<div class="w-full h-full flex flex-col ">
    <div class=" xs:h-[16%] md:h-[8%] flex justify-center align-middle w-screen xs:py-[5px] md:py-[18px] bg-gray-30">
        <img src="{{ url('assets/loginbanner.svg') }}" class=" xs:hidden md:block" alt="image" />
        <img src="{{ url('assets/loginbanner.svg') }}" class=" w-[40%] py-9 h-[144%] xs:block md:hidden"
            alt="image" />
    </div>
    <div class="lg:flex  justify-center align-middle gap-20 xs:h-[88%]  md:h-[90%] overflow-hidden">
        <img src="{{ url('assets/login_svg.svg') }}"
            class="lg:hidden sm:max-w-[25%] xs:max-w-[40%] xs:mt-[15%] sm:mt-[15%]  md:mt-5% ml-auto mr-auto mb-5"
            alt="image" />
        <div class="flex flex-col justify-center">
            <x-filament-socialite::buttons />
            <form wire:submit.prevent="authenticate" class="space-y-8 w-96 login">
                {{ $this->form }}
            </form>
        </div>
        <div class="mt-auto mb-auto flex">
            <img src="{{ url('assets/login_svg.svg') }}" class="xs:hidden lg:block " alt="image" />
        </div>
    </div>
    <div class="h-[2%] bg-green-750"></div>
</div>
