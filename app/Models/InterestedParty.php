<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterestedParty extends Model
{
    protected $fillable = [
        'identification_date',
        'name',
        'classification',
        'needs',
        'expectations',
        'communication_mechanisms',
        'responsible_by_id',
        'communication_frequency_days',
        'last_communication',
        'next_communication',
        'applicable_management_system',
        'legal_requirement_id',
        'process_id',
        'section',
        'stakeholder_attributes',
        'qualification_level',
        'compliance_level',
    ];

    protected $casts = [
        'identification_date' => 'date',
        'last_communication' => 'date',
        'next_communication' => 'date',
        'stakeholder_attributes' => 'array', // Casteo automático de JSON a Array
        'compliance_level' => 'array',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }

    public function legalRequirement(): BelongsTo
    {
        return $this->belongsTo(LegalRequirement::class);
    }
}
