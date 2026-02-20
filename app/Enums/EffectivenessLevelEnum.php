<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EffectivenessLevelEnum: string implements HasColor, HasLabel
{
    case EFFECTIVE = 'effective';
    case NEEDS_IMPROVEMENT = 'needs_improvement';
    case INEFFECTIVE = 'ineffective';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::EFFECTIVE => __('Effective'),
            self::NEEDS_IMPROVEMENT => __('Needs Improvement'),
            self::INEFFECTIVE => __('Ineffective'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::EFFECTIVE => 'success',
            self::NEEDS_IMPROVEMENT => 'warning',
            self::INEFFECTIVE => 'danger',
        };
    }
}
