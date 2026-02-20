<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AutomationLevelEnum: string implements HasLabel
{
    case MANUAL = 'daily';
    case AUTOMATIC = 'weekly';
    case SEMI_AUTOMATIC = 'semi_automatic';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MANUAL => __('Manual'),
            self::AUTOMATIC => __('Automatic'),
            self::SEMI_AUTOMATIC => __('Semi-Automatic'),
        };
    }
}
