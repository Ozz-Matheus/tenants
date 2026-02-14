<?php

declare(strict_types=1);

namespace App\Traits;

use Filament\Forms\Components\FileUpload;

trait HasStandardFileUpload
{
    public static function baseFileUpload(string $name = 'file'): FileUpload
    {
        // 1. Obtenemos la configuración centralizada
        // Usamos valores por defecto por seguridad si la config fallara
        $disk = config('holdingtec.uploads.disk', 'public');
        $mimes = config('holdingtec.uploads.allowed_mimes', []);
        $maxSizeKb = config('holdingtec.uploads.max_size_kb', 10240);
        $mimeTypes = config('holdingtec.uploads.mime_types', []);

        // 2. Calculamos los MB solo para mostrar en el texto de ayuda
        $maxSizeMb = round($maxSizeKb / 1024, 1);

        // 3. Obtenemos nombres únicos legibles (PDF, Word, Excel, etc.)
        $allowedLabels = collect($mimeTypes)->unique()->values()->implode(', ');

        return FileUpload::make($name)
            ->storeFileNamesIn('name') // Guarda el nombre original del archivo en la columna 'name'
            ->disk($disk)
            ->acceptedFileTypes($mimes)
            ->maxSize($maxSizeKb) // Filament espera el tamaño en KB
            ->helperText(__(
                'Allowed types: :types (max. :mbMB)',
                ['types' => $allowedLabels, 'mb' => $maxSizeMb]
            ));
    }
}
