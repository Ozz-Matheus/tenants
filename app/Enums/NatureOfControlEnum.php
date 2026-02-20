<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NatureOfControlEnum: string implements HasLabel
{
    case PREVENTIVE = 'preventive';
    case DETECTIVE = 'detective';
    case CORRECTIVE = 'corrective';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PREVENTIVE => __('Preventive'),
            self::DETECTIVE => __('Detective'),
            self::CORRECTIVE => __('Corrective'),
        };
    }
}
