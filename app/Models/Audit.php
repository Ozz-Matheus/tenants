<?php

namespace App\Models;

use Tapp\FilamentAuditing\Models\Audit as TappAudit;

class Audit extends TappAudit
{
    protected $table = 'audits';
}
