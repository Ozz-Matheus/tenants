<?php

namespace App\Enums;

use App\Traits\EnumHelpers;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RoleEnum: string implements HasColor, HasLabel
{
    use EnumHelpers;

    case SUPER_ADMIN = 'super_admin';
    case PANEL_USER = 'panel_user';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => __('Super Admin'),
            self::PANEL_USER => __('Panel User'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SUPER_ADMIN => 'indigo',
            self::PANEL_USER => 'warning',
        };
    }
}
