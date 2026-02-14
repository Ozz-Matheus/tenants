<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RiskTypeEnum: int implements HasLabel
{
    case STRATEGIC = 1;
    case OPERATIONAL = 2;
    case LEGAL = 3;
    case INFORMATION_SECURITY = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::STRATEGIC => __('Strategic'),
            self::OPERATIONAL => __('Operational'),
            self::LEGAL => __('Legal'),
            self::INFORMATION_SECURITY => __('Information Security'),
        };
    }
}
