<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Audit as AuditContract;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class ActionTask extends Model implements AuditableContract
{
    use AuditableTrait;

    protected $fillable = [
        'action_id',
        'title',
        'detail',
        'responsible_by_id',
        'start_date',
        'deadline',
        'actual_start_date',
        'actual_closing_date',
        'status_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
        'actual_start_date' => 'date',
        'actual_closing_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function responsibleBy()
    {
        return $this->belongsTo(User::class, 'responsible_by_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function taskComments()
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function taskFiles()
    {
        return $this->hasMany(ActionTaskFile::class, 'fileable_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function formatAuditFieldsForPresentation($field, AuditContract $record)
    {
        $fields = \Illuminate\Support\Arr::wrap($record->{$field} ?? []);

        $translations = [
            'action_id' => __('Acción'),
            'title' => __('Título'),
            'detail' => __('Detalle'),
            'responsible_by_id' => __('Responsable'),
            'start_date' => __('Fecha de inicio'),
            'deadline' => __('Fecha límite'),
            'actual_start_date' => __('Inicio real'),
            'actual_closing_date' => __('Cierre real'),
            'status_id' => __('Estado'),
        ];

        $omitFields = ['id'];

        $formatted = [];

        foreach ($fields as $key => $value) {
            $keyLower = Str::of($key)->snake()->value();
            $label = $translations[$keyLower] ?? Str::headline($keyLower);

            if (in_array($keyLower, $omitFields)) {
                continue;
            }

            if ($keyLower === 'action_id') {
                $value = optional(\App\Models\Action::find($value))->title ?? $value;
            }

            if ($keyLower === 'status_id') {
                $value = optional(\App\Models\Status::find($value))->label ?? $value;
            }

            if ($keyLower === 'responsible_by_id') {
                $value = optional(\App\Models\User::find($value))->name ?? $value;
            }

            if (in_array($keyLower, ['start_date', 'deadline', 'actual_start_date', 'actual_closing_date'])) {
                try {
                    \Carbon\Carbon::setLocale(app()->getLocale());
                    $value = \Carbon\Carbon::parse($value)->isoFormat('MMM D, YYYY');
                } catch (\Throwable $e) {
                    //
                }
            }

            $value = match (true) {
                is_scalar($value) => (string) $value,
                $value instanceof \DateTimeInterface => $value->format('d/m/Y H:i'),
                is_array($value), is_object($value) => json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?: '[Valor no representable]',
                default => '[Valor no representable]',
            };

            $formatted[] = "{$label}: <strong>{$value}</strong>";
        }

        return implode('<br>', $formatted);
    }
}
