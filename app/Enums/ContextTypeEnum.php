<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContextTypeEnum: int implements HasLabel
{
    case IMPACT = 1;
    case PROBABILITY = 2;
    case LEVEL = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::IMPACT => __('Impact'),
            self::PROBABILITY => __('Probability'),
            self::LEVEL => __('Level'),
        };
    }
}
