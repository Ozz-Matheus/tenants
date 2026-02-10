<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVersionDecision extends Model
{
    protected $table = 'users_versions_decisions';

    protected $fillable = [
        'version_id',
        'user_id',
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(DocVersion::class, 'version_id');
    }
}
