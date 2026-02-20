<?php

namespace App\Models;

use App\Enums\EffectivenessLevelEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Evaluation extends Model
{
    protected $fillable = [
        'control_id',
        'title',
        'evaluator_id',
        'design_is_suitable',
        'period_from',
        'period_to',
        'effectiveness_rating',
        'effectiveness_level',
        'observations',
        'requires_rca',
        'created_by_id',
        'updated_by_id',
    ];

    protected $casts = [
        'design_is_suitable' => 'boolean',
        'effectiveness_level' => EffectivenessLevelEnum::class,
        'requires_rca' => 'boolean',
    ];

    public function control(): BelongsTo
    {
        return $this->belongsTo(Control::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
