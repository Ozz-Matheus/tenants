<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Number;

class File extends Model
{
    //
    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'name',
        'path',
        'mime_type',
        'size',
        'context',
    ];

    protected $casts = [
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function fileable()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Accesores / Métodos útiles
    |--------------------------------------------------------------------------
    */

    public function scopeContext($query, $context)
    {
        return $query->where('context', $context);
    }

    /*
    |--------------------------------------------------------------------------
    | Lógica de URL (Centralizada)
    |--------------------------------------------------------------------------
    */
    public function url(): ?string
    {
        $disk = config('holdingtec.uploads.disk', 'public');

        // 1. Local / Privado
        if ($disk === 'local') {
            return URL::temporarySignedRoute(
                'files.secure.show',
                now()->addMinutes(60),
                ['file' => $this->id]
            );
        }

        // 2. Tenancy (Symlinks)
        $tenantId = tenant()?->getTenantKey();
        if ($tenantId && $disk === 'public') {
            $cleanTenantId = preg_replace('/[^a-zA-Z0-9_\-]/', '', $tenantId);
            $suffixBase = config('tenancy.filesystem.suffix_base', 'tenant');

            return asset("{$suffixBase}{$cleanTenantId}/{$this->path}");
        }

        // 3. Standard
        return Storage::disk($disk)->url($this->path);
    }

    /*
    |--------------------------------------------------------------------------
    | Accesores
    |--------------------------------------------------------------------------
    */

    protected function readableMimeType(): Attribute
    {
        return Attribute::make(
            get: function () {
                $mimeTypes = config('holdingtec.uploads.mime_types', []);

                return $mimeTypes[$this->mime_type] ?? __('Other');
            }
        );
    }

    protected function readableSize(): Attribute
    {
        return Attribute::make(
            get: fn () => Number::fileSize($this->size ?? 0)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers Booleanos
    |--------------------------------------------------------------------------
    */

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf'
            || str_ends_with(strtolower($this->name), '.pdf');
    }

    public function isOfficeEmbeddable(): bool
    {
        $officeMimes = config('holdingtec.uploads.office_mimes', []);

        if (in_array($this->mime_type, $officeMimes, true)) {
            return true;
        }

        // Fallback por si el mime falla
        return (bool) preg_match('/\.(docx?|xlsx?)$/i', $this->name);
    }
}
