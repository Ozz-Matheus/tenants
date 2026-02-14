<?php

namespace App\Models;

use App\Enums\DocStorageEnum;
use Illuminate\Database\Eloquent\Model;

class DocRecovery extends Model
{
    protected $fillable = ['storage_id', 'title'];

    protected $casts = ['storage_id' => DocStorageEnum::class];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function storage()
    {
        return $this->belongsTo(DocStorageEnum::class, 'storage_id');
    }

    public function docs()
    {
        return $this->hasMany(Doc::class);
    }
}
