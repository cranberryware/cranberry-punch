<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class IpAddress implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            $fail('The :attribute field must be a valid IP Address.');
        }
    }
}
