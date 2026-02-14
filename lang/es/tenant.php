<?php

return [
    'group' => 'Configuraciones',
    'title' => 'Tenants',
    'single' => 'Tenant',
    'invalid_format' => 'El formato del campo :attribute es inválido. Usa solo letras minúsculas, números y guiones.',
    'only_lowercase_allowed' => 'Sólo letras minúsculas, números y guiones (en: mi-empresa)',
    'identifier' => 'Identificador',
    'link_existing_database' => 'Vincular base de datos existente',
    'workspace_deactivated' => 'Espacio de trabajo desactivado',
    'workspace_deactivated_description' => 'Este espacio de trabajo está actualmente desactivado...',
    'database_not_found_or_unauthorized' => "La base de datos ':value' no existe o no está autorizada. Verifique con soporte.",
    'columns' => [
        'id' => 'ID',
        'name' => 'Nombre',
        'unique_id' => 'ID Único',
        'domain' => 'Dominio',
        'email' => 'Correo Electrónico',
        'phone' => 'Teléfono',
        'password' => 'Contraseña',
        'passwordConfirmation' => 'Confirmar Contraseña',
        'is_active' => 'Está Activo',
        'created_at' => 'Creado En',
        'updated_at' => 'Actualizado En',
    ],
    'actions' => [
        'view' => 'Abrir Tenant',
        'login' => 'Iniciar Sesión en Tenant',
        'password' => 'Cambiar Contraseña',
        'edit' => 'Editar',
        'delete' => 'Eliminar',
    ],
    'domains' => [
        'title' => 'Dominios',
        'single' => 'Dominio',
        'columns' => [
            'domain' => 'Dominio',
            'full' => 'Dominio Completo',
        ],
    ],
];
