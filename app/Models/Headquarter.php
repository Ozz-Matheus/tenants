<?php

namespace App\Models;

use App\Support\AppNotifier;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Headquarter extends Model
{
    protected $fillable = ['name', 'acronym'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    protected static function booted(): void
    {
        static::deleting(function (Headquarter $hq) {

            if ($hq->users()->exists()) {

                AppNotifier::danger(
                    __('headquarter.model_label'),
                    __('reassign_before_delete'),
                );

                throw new Halt;
            }

        });
    }
}
