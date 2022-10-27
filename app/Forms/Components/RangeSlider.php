<?php

namespace App\Forms\Components;

use Filament\Support\Concerns\HasExtraAttributes;
use Yepsua\Filament\Forms\Components\RangeSlider as YepsuaRangeSlider;

class RangeSlider extends YepsuaRangeSlider
{
    use HasExtraAttributes;
    protected string $view = 'forms.components.range-slider';
}
