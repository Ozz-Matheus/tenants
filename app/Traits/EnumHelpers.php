<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumHelpers
{
    public static function getLabelFromValue(string $value): string
    {
        // Intenta encontrar el caso del Enum, si existe obtiene su label,
        return self::tryFrom($value)?->getLabel() ?? Str::headline($value);
    }

    public static function getColorFromValue(string $value, string $default = 'primary'): string|array|null
    {
        // Intenta encontrar el caso y obtener su color.
        return self::tryFrom($value)?->getColor() ?? $default;
    }
}
