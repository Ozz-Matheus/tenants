<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RiskTypeEnum: string implements HasLabel
{
    case STRATEGIC = 'strategic';
    case OPERATIONAL = 'operational';
    case LEGAL = 'legal';
    case INFORMATION_SECURITY = 'information_security';

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
