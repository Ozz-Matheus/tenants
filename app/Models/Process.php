<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = [
        'title',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function subprocesses()
    {
        return $this->hasMany(Subprocess::class);
    }

    public function docs()
    {
        return $this->hasMany(Doc::class);
    }
}
