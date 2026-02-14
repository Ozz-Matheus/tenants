<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemValue extends Model
{
    protected $fillable = [
        'item_type',
        'strategic_context_id',
        'title',
        'value',
        'description',
    ];

    public function strategicContext()
    {
        return $this->belongsTo(StrategicContext::class);
    }
}
