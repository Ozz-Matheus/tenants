<?php

namespace App\Models;

use App\Enums\ContextTypeEnum;
use App\Enums\RiskTreatmentEnum;
use App\Enums\RiskTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Risk extends Model
{
    protected $fillable = [
        'title',
        'description',
        'risk_type',
        'process_id',
        'subprocess_id',
        'strategic_context_type',
        'inherent_impact_id',
        'inherent_probability_id',
        'inherent_level_id',
        'treatment',
    ];

    protected $casts = [
        'risk_type' => RiskTypeEnum::class,
        'strategic_context_type' => StrategicContextTypeEnum::class,
        'treatment' => RiskTreatmentEnum::class,
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }

    public function subprocess(): BelongsTo
    {
        return $this->belongsTo(Subprocess::class);
    }

    public function inherentImpact(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'inherent_impact_id')
            ->where('context_type', ContextTypeEnum::IMPACT);
    }

    public function inherentProbability(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'inherent_probability_id')
            ->where('context_type', ContextTypeEnum::PROBABILITY);
    }

    public function inherentLevel(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'inherent_level_id')
            ->where('context_type', ContextTypeEnum::LEVEL);
    }

    public function impactItems(): HasMany
    {
        return $this->hasMany(ImpactItem::class);
    }

    public function probabilityItems(): HasMany
    {
        return $this->hasMany(ProbabilityItem::class);
    }
}
