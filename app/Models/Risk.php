<?php

namespace App\Models;

use App\Enums\CriteriaTypeEnum;
use App\Enums\RiskTreatmentEnum;
use App\Enums\RiskTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use App\Traits\BelongsToHeadquarter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Risk extends Model
{
    use BelongsToHeadquarter;

    protected $fillable = [
        'classification_code',
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
        'residual_impact_id',
        'residual_probability_id',
        'residual_level_id',
        'created_by_id',
        'updated_by_id',
        'headquarter_id',
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
            ->where('criteria_type', CriteriaTypeEnum::IMPACT)->orderBy('id', 'asc');
    }

    public function inherentProbability(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'inherent_probability_id')
            ->where('criteria_type', CriteriaTypeEnum::PROBABILITY)->orderBy('id', 'asc');
    }

    public function inherentLevel(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'inherent_level_id')
            ->where('criteria_type', CriteriaTypeEnum::LEVEL)->orderBy('id', 'asc');
    }

    public function impactItems(): HasMany
    {
        return $this->hasMany(ImpactItem::class);
    }

    public function probabilityItems(): HasMany
    {
        return $this->hasMany(ProbabilityItem::class);
    }

    public function residualImpact(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'residual_impact_id')
            ->where('criteria_type', CriteriaTypeEnum::IMPACT)->orderBy('id', 'asc');
    }

    public function residualProbability(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'residual_probability_id')
            ->where('criteria_type', CriteriaTypeEnum::PROBABILITY)->orderBy('id', 'asc');
    }

    public function residualLevel(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'residual_level_id')
            ->where('criteria_type', CriteriaTypeEnum::LEVEL)->orderBy('id', 'asc');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function controls(): BelongsToMany
    {
        return $this->belongsToMany(Control::class, 'risks_has_controls');
    }
}
