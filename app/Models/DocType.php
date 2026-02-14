<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocType extends Model
{
    protected $fillable = [
        'title',
        'acronym',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function docs()
    {
        return $this->hasMany(Doc::class, 'doc_type_id');
    }
}
