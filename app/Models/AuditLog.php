<?php

namespace App\Models;

use Tapp\FilamentAuditing\Models\Audit as TappAudit;

class AuditLog extends TappAudit
{
    protected $table = 'audits';
}
