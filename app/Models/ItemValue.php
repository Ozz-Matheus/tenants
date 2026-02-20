<?php

namespace App\Models;

use App\Enums\CriteriaTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use Illuminate\Database\Eloquent\Model;

class ItemValue extends Model
{
    protected $fillable = [
        'item_criteria_type',
        'strategic_context_type',
        'strategic_context_id',
        'title',
        'value',
        'description',
    ];

    protected $casts = [
        'item_criteria_type' => CriteriaTypeEnum::class,
        'strategic_context_type' => StrategicContextTypeEnum::class,
    ];

    public function strategicContext()
    {
        return $this->belongsTo(StrategicContext::class);
    }
}
