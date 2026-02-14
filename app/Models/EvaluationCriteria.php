<?php

namespace App\Models;

use App\Enums\ContextTypeEnum;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    protected $fillable = [
        'context_type',
        'title',
        'min',
        'max',
        'weight',
        'description',
        'color',
    ];

    protected $casts = [
        'context_type' => ContextTypeEnum::class,
    ];
}
