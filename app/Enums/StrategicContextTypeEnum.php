<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StrategicContextTypeEnum: string implements HasLabel
{
    case INTERNAL = 'internal';
    case EXTERNAL = 'external';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INTERNAL => __('Internal'),
            self::EXTERNAL => __('External'),
        };
    }
}
