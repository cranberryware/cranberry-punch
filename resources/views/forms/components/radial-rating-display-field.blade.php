<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }" class="radial-graph-wrap">
        <div class="radial-graph">
            <div class="rg-shape">
                <div class="rg-mask rg-full-mask" style="transform: rotate({{$getMaskDegrees()}}deg)">
                    <div class="rg-fill" style="transform: rotate({{$getMaskDegrees()}}deg)"></div>
                </div>
                <div class="rg-mask">
                    <div class="rg-fill" style="transform: rotate({{$getMaskDegrees()}}deg)"></div>
                    <div class="rg-fill rg-shim" style="transform: rotate({{$getShimDegrees()}}deg)"></div>
                </div>
            </div>
            <div class="rg-cutout">
                <span class="rg-value">{!! \App\Support\Str::subscript_decimal($getState()) !!}</span> <span class="rg-separator">/</span> <span class="rg-max">{{$getMax()}}</span>
            </div>
        </div>
    </div>
</x-forms::field-wrapper>
