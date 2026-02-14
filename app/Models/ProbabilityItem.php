<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProbabilityItem extends Model
{
    protected $fillable = [
        'risk_id',
        'cause_id',
        'description',
        'value_id',
    ];

    public function risk(): BelongsTo
    {
        return $this->belongsTo(Risk::class);
    }

    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class);
    }

    public function itemValue(): BelongsTo
    {
        return $this->belongsTo(ItemValue::class, 'value_id');
    }
}
