<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActionPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    // Define que este modelo puede pertenecer a varios otros modelos
    public function actionable(): MorphTo
    {
        return $this->morphTo();
    }
}
