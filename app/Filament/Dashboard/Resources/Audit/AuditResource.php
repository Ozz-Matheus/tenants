<?php

namespace App\Filament\Dashboard\Resources\Audit;

use App\Models\Audit;
use Tapp\FilamentAuditing\Filament\Resources\Audits\AuditResource as TappAuditResource;

class AuditResource extends TappAuditResource
{
    protected static ?string $model = Audit::class;
}
