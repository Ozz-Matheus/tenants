<?php

namespace App\Models;

use App\Enums\EffectivenessLevelEnum;
use Illuminate\Database\Eloquent\Model;

class EffectivenessLevelRange extends Model
{
    protected $fillable = [
        'effectiveness_level',
        'min_rating',
        'max_rating',
    ];

    protected $casts = [
        'effectiveness_level' => EffectivenessLevelEnum::class,
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
