<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StorageMethodEnum: string implements HasLabel
{
    case PHYSYCAL = 'physical';
    case DIGITAL = 'digital';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PHYSYCAL => __('doc.storage_method_physical'),
            self::DIGITAL => __('doc.storage_method_digital'),
        };
    }
}
