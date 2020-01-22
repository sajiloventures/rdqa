<?php

return [

    'page'    =>
    [
        'home' => 'Home',
    ],

    'columns' => [
        /*general*/
        'id'                    => 'ID',
        'username'              => 'Username',
        'name'                  => 'Name',        
        'first_name'            => 'First Name',
        'last_name'             => 'Last Name',
        'roles'                 => 'Roles',
        'email'                 => 'Email',
        'password'              => 'Password',
        'password_confirmation' => 'Password confirmation',
        'created'               => 'Created',
        'updated'               => 'Updated',
        'actions'               => 'Actions',
        'enabled'               => 'Enabled',
        'date'                  => 'Date',
        'title'                 => 'Title',
        'status'                => 'Status',
        'effective'             => 'Effective',
        'description'           => 'Description',
        'action_name'           => 'Action Name',

        /*roles*/
        'display_name'          => 'Display Name',
        'permissions'           => 'Permissions',
        'users'                 => 'Users',
        /*permission*/
        'routes'                => 'Routes',
        'method'                => 'Method',
        'path'                  => 'Path',
        'permission'            => 'Permission',

        /*configuration*/
        'key'                   => 'Key',
        'value'                 => 'Value',
        'remarks'               => 'Remarks',

    ],

    'show'    => [
        /*general*/
        'id'                    => 'ID',
        'username'              => 'Username',
        'name'                  => 'Name',
        'roles'                 => 'Roles',
        'email'                 => 'Email',
        'password'              => 'Password',
        'password_confirmation' => 'Password confirmation',
        'created'               => 'Created',
        'updated'               => 'Updated',
        'actions'               => 'Actions',
        'enabled'               => 'Enabled',
        'date'                  => 'Date',

    ],

    'button'  => [
        'add'           => 'Add',
        'cancel'        => 'Cancel',
        'close'         => 'Close',
        'back'          => 'Back',
        'create'        => 'Create',
        'delete'        => 'Delete',
        'edit'          => 'Edit',
        'ok'            => 'OK',
        'update'        => 'Update',
        'upload'        => 'Upload',
        'enable'        => 'Enable',
        'enabled'       => 'Enabled',
        'disable'       => 'Disable',
        'disabled'      => 'Disabled',
        'toggle-select' => 'Toggle checkboxes',
        'remove-role'   => 'Remove role',
        'save'          => 'Save',
        'save-list'     => 'Save & list',
        'save-add'      => 'Save & add new',
        'save-edit'     => 'Save & continue edit',
        'view'          => 'View',
        'noview'        => 'No view',
        'adduser'       => 'Add user',
        'impersonate'   => 'Impersonate user',

    ],

    'modal'   => [
        'user_refer'    => 'User refer detail',
        'paid_status'   => 'Paid status',
        'reffered_user' => 'Referred user',
        'amount'        => 'Amount',
        'paid'          => 'Paid',
        'adduser'       => 'Add user',

    ],

    'common'  => [
        'free' => 'Free',
    ],

    'status'  => [
        'enabled' => 'Enabled',
    ],
    'tabs'    => [
        'details'                     => 'Details',
        'options'                     => 'Options',
        'perms'                       => 'Permissions',
        'users'                       => 'Users',
        'roles'                       => 'Roles',
        'routes'                      => 'Routes',
        'action'                      => 'Action',
        'trial'                       => 'Trial',
        'profile'                     => 'Profile Information',
        'emergency'                   => 'Emergency Contact Information',
        'general_details_tab_content' => 'User Detail',
        'admin'                       => 'Admin',

        /*settings*/
        'basic'                       => 'Basic',
        'advanced'                       => 'Advance',
        'smtp'                       => 'SMTP',
        'social_net'                       => 'Socail Networks',
    ],

    'error'   => [
        'title-403'                 => 'Error 403',
        'title-404'                 => 'Error 404',
        'title-500'                 => 'Error 500',
        'description-403'           => '',
        'description-404'           => '',
        'description-500'           => '',
        'forbidden-403'             => 'Forbidden',
        'page-not-found-404'        => 'Page not found',
        'internal-error-500'        => 'Internal error',
        'client-error'              => 'Client error: :error-code',
        'server-error'              => 'Server error: :error-code',
        'what-is-this'              => 'What does this mean?',
        '403-explanation'           => 'The page or function that you tried to access is forbidden. We have logged your IP address.',
        '404-explanation'           => 'The page or function that you are looking for could not be located. Please go back to the previous page or select a new one.',
        '500-explanation'           => 'A serious problem occurred on the server, we will look at it ASAP and fix whatever broke.',
        'error-proc-command'        => 'Error processing command: :cmd',
        'SITE_CONFIG_EMPTY'         => 'No configuration data found. This may break the application.',
        'SITE_CONFIG_KEY_NOT_EXIST' => 'Requested configuration key: ":key" does not exist. This key must exist on Site Configuration, accessible on Admin Panel as Settings >> Configuration or URL: admin/configure',

    ],

    'layout'  => [
        'left_sidebar' => [
            'list' => 'List',
            'add'  => 'Add',
        ],
    ],

];
