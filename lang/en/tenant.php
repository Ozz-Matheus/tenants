<?php

return [
    'group' => 'Settings',
    'title' => 'Tenants',
    'single' => 'Tenant',
    'invalid_format' => 'The :attribute format is invalid. Use only lowercase letters, numbers, and dashes.',
    'only_lowercase_allowed' => 'Only lowercase letters, numbers and hyphens (in: my-company)',
    'identifier' => 'Identifier',
    'link_existing_database' => 'Link Existing Database',
    'workspace_deactivated' => 'Workspace Deactivated',
    'workspace_deactivated_description' => 'This workspace is currently deactivated...',
    'database_not_found_or_unauthorized' => "The database ':value' does not exist or is not authorized. Please check with support.",
    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'unique_id' => 'Unique ID',
        'domain' => 'Domain',
        'email' => 'Email',
        'phone' => 'Phone',
        'password' => 'Password',
        'passwordConfirmation' => 'Password Confirmation',
        'is_active' => 'Is Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'actions' => [
        'view' => 'Open Tenant',
        'login' => 'Login To Tenant',
        'password' => 'Change Password',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],
    'domains' => [
        'title' => 'Domains',
        'single' => 'Domain',
        'columns' => [
            'domain' => 'Domain',
            'full' => 'Full Domain',
        ],
    ],

];
