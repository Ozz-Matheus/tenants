<?php

namespace App\Models;

use App\Support\AppHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = [
        'owner_by_id',
        'name',
        'is_active',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'owner_by_id',
            'name',
            'is_active',
            'data',
        ];
    }

    public function ownerBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_by_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers
    |--------------------------------------------------------------------------
    */

    public function adminUrl(): Attribute
    {
        return Attribute::get(fn () => AppHelper::getTenantUrl(
            $this->domains->first()?->domain
        ));
    }
}
