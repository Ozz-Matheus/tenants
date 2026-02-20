<?php

namespace App\Models;

use App\Enums\CriteriaTypeEnum;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    protected $fillable = [
        'criteria_type',
        'title',
        'description',
        'min',
        'max',
        'weight',
        'color',
    ];

    protected $casts = [
        'criteria_type' => CriteriaTypeEnum::class,
    ];
}
