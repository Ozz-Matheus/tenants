<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RiskTreatmentEnum: int implements HasLabel
{
    case REDUCE_MITIGATE = 1;
    case TRANSFER_SHARE = 2;
    case AVOID = 3;
    case ACCEPT = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::REDUCE_MITIGATE => __('Reducir/Mitigar'),
            self::TRANSFER_SHARE => __('Transferir/Compartir'),
            self::AVOID => __('Evitar'),
            self::ACCEPT => __('Aceptar'),
        };
    }
}
