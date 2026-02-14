<?php

return [
    'model_label' => 'Documento',
    'plural_model_label' => 'Documentos',

    // Columns & Filters
    'classification_code' => 'Código de clasificación',
    // 'doc_type' => 'Tipo de documento',
    // 'process' => 'Proceso',🗣️
    // 'sub_process' => 'Subproceso',
    'version' => 'Versión',
    'leads' => 'Lidera',
    'Leader' => 'Líder',
    'confidential' => 'Confidencialidad',
    'private' => 'Privado',
    'public' => 'Público',

    // File viewer
    'decision_history' => 'Historial de decisiones',
    'decision' => 'Decisión',
    'decision_saved' => 'Decisión guardada exitosamente',
    'permission_denied' => 'No tienes permiso para ver este documento.',
    'unauthorized_subprocess' => 'No autorizado para acceder a este subproceso.',
    'user_update_success' => 'Usuarios actualizados exitosamente',
    'user_update_error' => 'Se produjo un error al actualizar los usuarios',

    // Acciones
    'update_additional_users' => 'Actualizar usuarios adicionales',
    'access_additional_users' => 'Acceso a usuarios adicionales',

    'versions' => [

        'model_label' => 'Historial de versiones',
        'plural_model_label' => 'Versiones',

        // Notificación
        'created_notice' => '¡Nuevo documento creado!',
        'status_notice' => 'Estado del documento',
        'status_changed_to' => 'El documento pasó a :status',

        'actions' => [
            'create' => 'Crear Versión',
        ],

    ],
];
