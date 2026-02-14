<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cause extends Model
{
    protected $fillable = ['title'];

    public function risks(): BelongsToMany
    {
        return $this->belongsToMany(Risk::class, 'risks_has_causes');
    }
}
