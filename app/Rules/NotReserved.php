<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Config;

class NotReserved implements Rule
{
    public function passes($attribute, $value)
    {
        $reservedWords = Config::get('reserved_keywords.words', []);
        return !in_array(strtolower($value), $reservedWords);
    }

    public function message()
    {
        return 'The :attribute is reserved and cannot be used.';
    }
}
