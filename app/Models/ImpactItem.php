<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpactItem extends Model
{
    protected $fillable = [
        'risk_id',
        'strategic_context_id',
        'description',
        'value_id',
    ];

    public function risk(): BelongsTo
    {
        return $this->belongsTo(Risk::class);
    }

    public function strategicContext(): BelongsTo
    {
        return $this->belongsTo(StrategicContext::class);
    }

    public function itemValue(): BelongsTo
    {
        return $this->belongsTo(ItemValue::class, 'value_id');
    }
}
