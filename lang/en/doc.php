<?php

return [
    'model_label' => 'Document',
    'plural_model_label' => 'Documents',

    // Columns & Filters
    'classification_code' => 'Classification Code',
    // 'doc_type' => 'Document Type',
    // 'process' => 'Process', 🗣️
    // 'sub_process' => 'Subprocess',
    'version' => 'Version',
    'leads' => 'Leads',
    'Leader' => 'Leader',
    'confidential' => 'Confidentiality',
    'private' => 'Private',
    'public' => 'Public',

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

    'versions' => [

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
];
