<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidSubdomain implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $value)) {
            $fail('The :attribute format is invalid. Use only lowercase letters, numbers, and dashes.')->translate();
        }
    }
}
