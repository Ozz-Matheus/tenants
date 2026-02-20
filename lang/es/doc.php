<?php

return [
    'navigation_group' => 'Gestión de Documentos',
    'model_label' => 'Documento',
    'plural_model_label' => 'Documentos',

    // Columns & Filters
    'leads' => 'Lidera',
    'Leader' => 'Líder',
    'leaders' => 'Líderes',
    'confidential' => 'Confidencialidad',
    'private' => 'Privado',
    'public' => 'Público',
    'latest_version' => 'Última versión',
    'meets' => 'Cumple con los requisitos',
    'storage_method' => 'Método de almacenamiento',
    'storage_method_physical' => 'Físico',
    'storage_method_digital' => 'Digital',
    'recovery_method' => 'Método de Recuperación',
    'disposition_method' => 'Método de Disposición',
    'retention_time' => 'Tiempo de retención',

    // Infolists
    'id' => 'Identificación del documento',
    'context' => 'Contexto operativo',
    'control' => 'Control de formato',
    'data' => 'Metadatos',

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
    'rejected_comment_label' => 'Confirmar Rechazo',
    'rejected_comment_placeholder' => '¿Motivo del rechazo?',

    'version' => [

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

    'type' => [

        'model_label' => 'Tipo de documento',
        'plural_model_label' => 'Tipos de documentos',

    ],

    'recovery' => [

        'model_label' => 'Recuperación de Documento',
        'plural_model_label' => 'Recuperaciones de Documentos',

    ],

    'disposition' => [

        'model_label' => 'Disposición de Documento',
        'plural_model_label' => 'Disposiciones de Documentos',

    ],
];
