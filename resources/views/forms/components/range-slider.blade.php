<x-forms::field-wrapper :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div x-data="{
        state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')') }}
    }">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-9">
                <input id="{{$getId()}}" type="range" x-model="state" class="focus:outline-none focus:bg-primary-200 dark:focus:bg-primary-900 disabled:opacity-70 disabled:cursor-not-allowed filament-forms-range-component border-gray-300 bg-gray-200 dark:bg-white/10 w-90" {!! $isRequired() ? 'required' : null !!} {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}" min="{{ $getMin()}}" max="{{ $getMax()}}" step="{{ $getStep()}}" dusk="filament.forms.{{ $getStatePath() }}" {!! $isDisabled() ? 'disabled' : null !!} />
            </div>
            <div class="col-span-3">
                <input id="{{$getId()}}-value" type="number" x-model="state" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 border-gray-300 text-center" {!! $isRequired() ? 'required' : null !!} {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}" min="{{ $getMin()}}" max="{{ $getMax()}}" step="{{ $getStep()}}" dusk="filament.forms.{{ $getStatePath() }}" {!! $isDisabled() ? 'disabled' : null !!} />
            </div>
        </div>
        @if (($steps = $getSteps()) && $getDisplaySteps() === true)
        <ul class="flex justify-between w-full px-[10px]">
            @foreach ($steps as $key => $step)
            @include('filament-range-field::forms.components._range-slider-step', [
            'state' => $getStepsAssoc() ? $key : $loop->iteration,
            'step' => $step
            ])
            @endforeach
        </ul>
        @endif
    </div>
</x-forms::field-wrapper>