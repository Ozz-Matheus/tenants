<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subprocess extends Model
{
    protected $fillable = [
        'title',
        'process_id',
        'acronym',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function leaders()
    {
        return $this->belongsToMany(User::class, 'users_lead_subprocesses');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_sub_processes');
    }

    public function docs()
    {
        return $this->hasMany(Doc::class);
    }
}
