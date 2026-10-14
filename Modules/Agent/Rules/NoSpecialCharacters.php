<?php

namespace Modules\Agent\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoSpecialCharacters implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
            $attribute = ucfirst(str_replace('_', ' ', $attribute));
            $fail("The $attribute cannot contain special characters.");
        }
    }
}
