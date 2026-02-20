<?php

namespace App\Models;

use App\Enums\AutomationLevelEnum;
use App\Enums\EffectivenessLevelEnum;
use App\Enums\FrequencyEnum;
use App\Enums\NatureOfControlEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Control extends Model
{
    protected $fillable = [
        'nature_of_control',
        'title',
        'description',
        'automation_level',
        'frequency',
        'responsible_id',
        'effectiveness_rating',
        'effectiveness_level',
    ];

    protected $casts = [
        'nature_of_control' => NatureOfControlEnum::class,
        'automation_level' => AutomationLevelEnum::class,
        'frequency' => FrequencyEnum::class,
        'effectiveness_level' => EffectivenessLevelEnum::class,
    ];

    public function risks(): BelongsToMany
    {
        return $this->belongsToMany(Risk::class, 'risks_has_controls');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }
}
