<?php

namespace App\Traits;

use App\Models\ProcessAudit;

trait HasAuditContext
{
    public ?int $audit_id = null;

    public ?ProcessAudit $auditModel = null;

    public function loadAuditContext(): void
    {
        $this->audit_id = request()->route('audit');

        $this->auditModel = ProcessAudit::findOrFail($this->audit_id);
    }
}
