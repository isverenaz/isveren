<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        // Telefon nömrəsinin +994509993366 formatında olub-olmadığını yoxlayır
        return preg_match('/^\+994\d{9}$/', $value);
    }

    public function message()
    {
        return 'Telefon nömrəsi +994XXXXXXXXX formatında olmalıdır.';
    }
}
