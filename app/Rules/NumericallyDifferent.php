<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class NumericallyDifferent implements Rule, DataAwareRule
{
    use ValidatesAttributes;

    protected $parameters;

    protected $attribute;

    protected $message = "The :attribute must be different from :other.";

    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($parameters, $message = null)
    {
        $this->parameters = $parameters;
        $this->message = $message;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;
        $value = (int) $value;
        return $this->validateDifferent($attribute, $value, $this->parameters);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __($this->message, [
            'attribute' => $this->attribute,
            'other' => $this->parameters[0],
        ]);
    }
}
