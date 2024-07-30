<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RequiredOne implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        // Check if the value is an array and has at least one item
        return is_array($value) && count($value) > 0;
    }

    public function message()
    {
        return 'The :attribute field must contain at least one item.';
    }
}
