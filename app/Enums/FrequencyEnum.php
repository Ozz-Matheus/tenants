<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FrequencyEnum: string implements HasLabel
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case SEMIANNUAL = 'semiannual';
    case ANNUAL = 'annual';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DAILY => __('Daily'),
            self::WEEKLY => __('Weekly'),
            self::MONTHLY => __('Monthly'),
            self::QUARTERLY => __('Quarterly'),
            self::SEMIANNUAL => __('Semiannual'),
            self::ANNUAL => __('Annual'),
        };
    }
}
