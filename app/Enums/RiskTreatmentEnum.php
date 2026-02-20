<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RiskTreatmentEnum: string implements HasLabel
{
    case REDUCE_MITIGATE = 'reduce_mitigate';
    case TRANSFER_SHARE = 'transfer_share';
    case AVOID = 'avoid';
    case ACCEPT = 'accept';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::REDUCE_MITIGATE => __('Reduce/Mitigate'),
            self::TRANSFER_SHARE => __('Transfer/Share'),
            self::AVOID => __('Avoid'),
            self::ACCEPT => __('Accept'),
        };
    }
}
