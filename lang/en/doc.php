<?php

return [
    'navigation_group' => 'Document Management',
    'model_label' => 'Document',
    'plural_model_label' => 'Documents',

    // Columns & Filters
    'leads' => 'Leads',
    'Leader' => 'Leader',
    'leaders' => 'Leaders',
    'confidential' => 'Confidentiality',
    'private' => 'Private',
    'public' => 'Public',
    'latest_version' => 'Latest Version',
    'meets' => 'Meets Requirements',
    'storage_method' => 'Storage method',
    'storage_method_physical' => 'Physical',
    'storage_method_digital' => 'Digital',
    'recovery_method' => 'Recovery method',
    'disposition_method' => 'Disposition method',
    'retention_time' => 'Tiempo de retención',

    // Infolists
    'id' => 'Document Identification',
    'context' => 'Operational Context',
    'control' => 'Format Control',
    'data' => 'Metadata',

    // File viewer
    'decision_history' => 'Decision History',
    'decision' => 'Decision',
    'decision_saved' => 'Decision saved successfully',
    'permission_denied' => 'You do not have permission to view this document.',
    'unauthorized_subprocess' => 'Not authorized to access this subprocess.',
    'user_update_success' => 'Users updated successfully',
    'user_update_error' => 'An error occurred while updating users.',

    // Actions
    'update_additional_users' => 'Update Additional Users',
    'access_additional_users' => 'Access for Additional Users',
    'rejected_comment_label' => 'Confirm Rejection',
    'rejected_comment_placeholder' => 'Reason for the rejection?',

    'version' => [

        'model_label' => 'Version History',
        'plural_model_label' => 'Versions',

        // Notification
        'created_notice' => 'New document created!',
        'status_notice' => 'Document Status',
        'status_changed_to' => 'Document moved to :status',

        'actions' => [
            'create' => 'Create Version',
        ],

    ],

    'type' => [

        'model_label' => 'Doc Type',
        'plural_model_label' => 'Doc Types',

    ],

    'recovery' => [

        'model_label' => 'Doc Recovery',
        'plural_model_label' => 'Doc Recoveries',

    ],

    'disposition' => [

        'model_label' => 'Doc Disposition',
        'plural_model_label' => 'Doc Dispositions',

    ],
];
