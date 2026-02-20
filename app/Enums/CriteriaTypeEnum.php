<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CriteriaTypeEnum: string implements HasLabel
{
    case IMPACT = 'impact';
    case PROBABILITY = 'probability';
    case LEVEL = 'level';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::IMPACT => __('Impact'),
            self::PROBABILITY => __('Probability'),
            self::LEVEL => __('Level'),
        };
    }
}
