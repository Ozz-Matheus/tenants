<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LegalRequirement extends Model
{
    protected $fillable = [
        // 'system',
        'type',
        'name',
        'publication_date',
        'issuer',
        'article',
        'description',
        'application_evidence_path',
        'topic',
        'responsible_by_id',
        'process_id',
        'review_frequency_days',
        'last_review',
        'next_review',
        'validity',
        'status',
        'compliance',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'last_review' => 'date',
        'next_review' => 'date',
    ];

    public function responsibleBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_by_id');
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }

    public function actionPlans(): MorphMany
    {
        return $this->morphMany(ActionPlan::class, 'actionable');
    }
}
