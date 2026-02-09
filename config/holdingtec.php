<?php

$officeMimes = [
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
];

$imageMimes = [
    'image/jpeg',
    'image/png',
    'image/webp',
];

$pdfMime = ['application/pdf'];

return [

    /*
    |--------------------------------------------------------------------------
    | Configuración del Super Admin
    |--------------------------------------------------------------------------
    |
    | Credenciales predeterminadas para el usuario maestro en cada tenant.
    |
    */
    'super_admin' => [
        'email' => env('SUPER_ADMIN_EMAIL', 'admin@holdingtec.app'),
        'password' => env('SUPER_ADMIN_PASSWORD', 'password'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sistema de Archivos y Tenancy
    |--------------------------------------------------------------------------
    |
    | tenancy_public_dir: Carpeta pública donde se crean los symlinks (ej: public/tenant)
    | uploads_disk: Disco predeterminado para subidas de archivos en Filament.
    |
    */

    'filesystem' => [
        'tenancy_public_dir' => env('TENANCY_PUBLIC_DIR', 'public'), // Directorio público para symlinks
        'uploads_disk' => env('UPLOADS_DISK', 'public'),       // Disco por defecto para subidas
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración Global de Cargas (Uploads)
    |--------------------------------------------------------------------------
    |
    | Definimos límites y tipos permitidos globalmente.
    | Nota: Laravel usa KB para validaciones, por eso convierto 10MB a 10240KB.
    |
    */
    'uploads' => [

        'disk' => env('UPLOADS_DISK', 'public'),

        'max_size_kb' => 10240, // 10 MB (Estándar para reglas de validación de Laravel)

        'office_mimes' => $officeMimes,

        'allowed_mimes' => array_merge(
            $officeMimes,
            $pdfMime
        ),

        // Mapeo de MIME types a nombres legibles
        'mime_types' => [
            'application/pdf' => 'PDF',
            'application/msword' => 'Word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word',
            'application/vnd.ms-excel' => 'Excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Excel',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración General del QMS
    |--------------------------------------------------------------------------
    |
    | Aquí podemos agregar futuros ajustes globales del sistema.
    |
    */

];
