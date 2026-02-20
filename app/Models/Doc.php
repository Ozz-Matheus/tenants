<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Enums\StorageMethodEnum;
use App\Traits\BelongsToHeadquarter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Doc extends Model implements AuditableContract
{
    use AuditableTrait, BelongsToHeadquarter, SoftDeletes;

    //
    protected $fillable = [
        'classification_code',
        'title',
        'process_id',
        'subprocess_id',
        'doc_type_id',
        'central_expiration_date',
        'months_for_review_date',
        'storage_method',
        'retention_time',
        'recovery_method_id',
        'disposition_method_id',
        'confidential',
        'created_by_id',
        'updated_by_id',
        'headquarter_id',
    ];

    protected $casts = [
        'central_expiration_date' => 'date',
        'storage_method' => StorageMethodEnum::class,
        'confidential' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function type()
    {
        return $this->belongsTo(DocType::class, 'doc_type_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function subprocess()
    {
        return $this->belongsTo(Subprocess::class);
    }

    public function recoveryMethod()
    {
        return $this->belongsTo(DocRecovery::class, 'recovery_method_id');
    }

    public function dispositionMethod()
    {
        return $this->belongsTo(DocDisposition::class, 'disposition_method_id');
    }

    public function accessToAdditionalUsers()
    {
        return $this->belongsToMany(User::class, 'docs_has_confidential_users', 'doc_id', 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id')->withDefault();
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_id')->withDefault();
    }

    public function versions()
    {
        return $this->hasMany(DocVersion::class);
    }

    public function latestVersion()
    {
        return $this->hasOne(DocVersion::class)->latestOfMany('version');
    }

    public function latestApprovedVersion()
    {
        return $this->hasOne(DocVersion::class)
            ->where('status', StatusEnum::APPROVED)
            ->latest('version');
    }

    /*
    |--------------------------------------------------------------------------
    | Accesores / Métodos útiles
    |--------------------------------------------------------------------------
    */

    public function isAccessibleBy(User $user): bool
    {
        // Si no es confidencial, cualquiera con acceso al panel puede verlo
        if (! $this->confidential) {
            return true;
        }

        // Lógica de confidencialidad
        return $this->accessToAdditionalUsers()->where('users.id', $user->id)->exists()
            || $user->canAccessSubProcess($this->subprocess_id);
    }

    public function approvedVersionUrl(): ?string
    {
        return $this->latestApprovedVersion?->file->path
            ? $this->latestApprovedVersion->file->url()
            : null;
    }

    public function hasApprovedVersion(): bool
    {
        return ! empty($this->latestApprovedVersion?->file->path);
    }

    public function getContextPath(): string
    {
        $processTitle = $this->process?->title ?? null;
        $subprocessTitle = $this->subprocess?->title ?? null;

        return "{$processTitle} / {$subprocessTitle}";
    }
}
