<?php

return [

    'status' => [
        'created' => 'Role successfully created',
        'updated' => 'Role successfully updated',
        'deleted' => 'Role successfully deleted',
        'global-enabled' => 'Selected roles enabled.',
        'global-disabled' => 'Selected roles disabled.',
        'enabled' => 'Role enabled.',
        'disabled' => 'Role disabled.',
        'no-role-selected' => 'No role selected.',
    ],

    'error' => [
        'cant-delete-this-role' => 'This role cannot be deleted',
        'cant-edit-this-role' => 'This role cannot be edited',
    ],

    'page' => [
        'common' => [
            'permission' => 'Permission',
        ],
        'index' => [
            'title' => 'Admin | Roles',
            'description' => 'List of roles',
        ],
        'show' => [
            'title' => 'Admin | Role | Show',
            'description' => 'Displaying role: :name',
        ],
        'create' => [
            'title' => 'Admin | Role | Create',
            'description' => 'Creating a new role',
        ],
        'edit' => [
            'title' => 'Admin | Role | Edit',
            'description' => 'Editing role: :name',
        ],
    ],

    'layout' => [
        'left_sidebar' => [
            'main_menu' => 'Roles',
        ]
    ],

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'display_name' => 'Display name',
        'description' => 'Description',
        'permissions' => 'Permissions',
        'resync_on_login' => 'Re-sync on login',
        'options' => 'Options',
        'users' => 'Users',
        'created' => 'Created',
        'updated' => 'Updated',
        'actions' => 'Actions',
        'enabled' => 'Enabled',
        'username' => 'UserName',
    ],

    'button' => [
        'create' => 'Create new role',
    ],

    'content' => [
        'page'          => 'Role',
        'page-manager'  => 'Role Manager',
        'list'          => 'Role List',
        'show'          => 'Role Detail',
        'add'           => 'Role Add Form',
        'update'        => 'Update Form'
    ],
];
