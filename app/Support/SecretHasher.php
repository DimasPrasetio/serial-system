<?php

namespace App\Support;

class SecretHasher
{
    public static function hash(string $value): string
    {
        return hash('sha256', trim($value));
    }

    public static function mask(string $value, int $visible = 4): string
    {
        $value = trim($value);
        if (strlen($value) <= $visible) {
            return str_repeat('*', strlen($value));
        }

        return str_repeat('*', max(0, strlen($value) - $visible)).substr($value, -$visible);
    }
}
