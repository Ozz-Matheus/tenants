<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StrategicContextTypeEnum: int implements HasLabel
{
    case INTERNAL = 1;
    case EXTERNAL = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INTERNAL => __('Internal'),
            self::EXTERNAL => __('External'),
        };
    }
}
