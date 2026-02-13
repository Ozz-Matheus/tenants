<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleEnum;
use App\Support\AppNotifier;
use App\Traits\HasUserLogic;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, HasUserLogic, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'headquarter_id',
        'view_all_headquarters',
        'interact_with_all_headquarters',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
            'view_all_headquarters' => 'boolean',
            'interact_with_all_headquarters' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function docs()
    {
        return $this->hasMany(Doc::class);
    }

    public function docVersions()
    {
        return $this->hasMany(DocVersion::class);
    }

    public function subprocesses()
    {
        return $this->belongsToMany(Subprocess::class, 'user_has_subprocesses');
    }

    public function leaderOf()
    {
        return $this->belongsToMany(Subprocess::class, 'users_lead_subprocesses');
    }

    public function leadSubprocesses()
    {
        return $this->belongsToMany(Subprocess::class, 'users_lead_subprocesses', 'user_id', 'subprocess_id');
    }

    public function accessToAdditionalUsers()
    {
        return $this->belongsToMany(Doc::class, 'docs_has_confidential_users', 'doc_id', 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Filtros Reutilizables)
    |--------------------------------------------------------------------------
    */

    public function scopeWithoutSuperAdmin(Builder $query): void
    {
        $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', RoleEnum::SUPER_ADMIN);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accesores / Métodos útiles
    |--------------------------------------------------------------------------
    */

    /**
     * Determina si el usuario autenticado tiene prohibido modificar
     * campos críticos de un registro específico (incluyéndose a sí mismo).
     */
    public function isProtectedFrom(User $userBeingEdited): bool
    {
        // 1. Un usuario no puede modificarse ciertos campos críticos a sí mismo
        // (Para evitar quitarse el acceso, cambiarse de sede por error, etc.)
        if ($this->is($userBeingEdited)) {
            return true;
        }

        // 2. Si el usuario editado es Super Admin y quien edita no lo es, está protegido.
        if ($userBeingEdited->hasRole(RoleEnum::SUPER_ADMIN) &&
            ! $this->hasRole(RoleEnum::SUPER_ADMIN)) {
            return true;
        }

        return false;
    }

    // Metodos para el Acceso.

    public function isActive(): bool
    {
        return (bool) $this->active;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->hasRole(RoleEnum::SUPER_ADMIN)) {
            return true;
        }

        if ($reason = $this->getAccessDenialReason()) {

            Auth::logout();
            AppNotifier::danger($reason['title'], $reason['message'], true);

            return false;

        }

        return true;
    }

    private function getAccessDenialReason(): ?array
    {
        return match (true) {

            tenant()?->is_active === false => [
                'title' => __('Workspace Deactivated'),
                'message' => __('This workspace is currently deactivated...'),
            ],

            ! $this->isActive() => [
                'title' => __('Account Deactivated'),
                'message' => __('Your account has been deactivated...'),
            ],

            default => null,

        };
    }
}
