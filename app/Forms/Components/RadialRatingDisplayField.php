<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class RadialRatingDisplayField extends Field
{
    protected string $view = 'forms.components.radial-rating-display-field';
    protected float | int | Closure | null $min = null;
    protected float | int | Closure | null $max = null;

    /**
     * Sets the min value
     *
     * @param float $min
     * @return self
     */
    public function min(float | int | Closure $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Sets the max value
     *
     * @param float $max
     * @return self
     */
    public function max(float | int | Closure $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getMin(): ?int
    {
        return $this->evaluate($this->min);
    }

    public function getMax(): ?int
    {
        return $this->evaluate($this->max);
    }

    public function getShimDegrees(): int | float
    {
        return (($this->getState() * 360) / $this->getMax());
    }

    public function getMaskDegrees(): int | float
    {
        return ($this->getShimDegrees() / 2);
    }
}
