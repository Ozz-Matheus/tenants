<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class DocVersion extends Model
{
    protected $fillable = [
        'version',
        'comment',
        'sha256_hash',
        'status',
        'doc_id',
        'created_by_id',
    ];

    protected $casts = [
        'version' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => StatusEnum::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function doc()
    {
        return $this->belongsTo(Doc::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id')->withDefault();
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function leads()
    {
        return $this->belongsToMany(User::class, 'users_versions_decisions', 'version_id', 'user_id')
            ->withPivot('status', 'comment')
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Accesores / Métodos útiles
    |--------------------------------------------------------------------------
    */

    public function isLatestVersion(): bool
    {
        return $this->id === self::where('doc_id', $this->doc_id)
            ->orderByDesc('version')
            ->first()?->id;
    }

    public function isCompliant(): bool
    {
        return $this->isLatestVersion()
            && ! empty($this->sha256_hash)
            && $this->status === StatusEnum::APPROVED
            && filled($this->doc?->classification_code);
    }
}
