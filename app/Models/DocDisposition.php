<?php

namespace App\Models;

use App\Enums\StorageMethodEnum;
use Illuminate\Database\Eloquent\Model;

class DocDisposition extends Model
{
    protected $fillable = ['storage_method', 'title'];

    protected $casts = ['storage_method' => StorageMethodEnum::class];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function docs()
    {
        return $this->hasMany(Doc::class);
    }
}
