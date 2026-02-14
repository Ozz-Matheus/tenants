<?php

namespace App\Models;

use App\Enums\StrategicContextTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StrategicContext extends Model
{
    protected $fillable = [
        'type',
        'title',
    ];

    protected $casts = [
        'type' => StrategicContextTypeEnum::class,
    ];

    public function risks(): HasMany
    {
        return $this->hasMany(Risk::class);
    }
}
