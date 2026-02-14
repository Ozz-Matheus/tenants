<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocStorageEnum: int implements HasLabel
{
    case PHYSYCAL = 1;
    case DIGITAL = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PHYSYCAL => __('Physical'),
            self::DIGITAL => __('Digital')
        };
    }
}
