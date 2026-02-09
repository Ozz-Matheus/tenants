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

    public static function getColorFromValue(string $value, string $default = 'gray'): string|array|null
    {
        // Intenta encontrar el caso y obtener su color.
        return self::tryFrom($value)?->getColor() ?? $default;
    }

    public static function toOptions(): array
    {
        // Retorna un array ['value' => 'Label'].
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}
