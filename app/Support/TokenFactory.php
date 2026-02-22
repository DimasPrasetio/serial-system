<?php

namespace App\Support;

use Illuminate\Support\Str;

class TokenFactory
{
    public static function generateApiToken(): string
    {
        return 'tok_'.Str::random(48);
    }
}
