<?php

return [

    'status'  => [
        'created'          => 'Permission successfully created',
        'updated'          => 'Permission successfully updated',
        'deleted'          => 'Permission successfully deleted',
        'generated'        => 'Successfully generated :number permissions from routes.',
        'global-enabled'   => 'Selected permissions enabled.',
        'global-disabled'  => 'Selected permissions disabled.',
        'enabled'          => 'Permission enabled.',
        'disabled'         => 'Permission disabled.',
        'no-perm-selected' => 'No permission selected.',
    ],

    'error'   => [
        'cant-delete-this-permission' => 'This permission cannot be deleted',
        'cant-delete-perm-in-use'     => 'This permission is in use',
        'cant-edit-this-permission'   => 'This permission cannot be edited',
    ],

    'page'    => [
        'index'  => [
            'title'       => 'Admin | Permissions',
            'description' => 'List of permissions',
        ],
        'show'   => [
            'title'       => 'Admin | Permission | Show',
            'description' => 'Displaying permission: :name',
        ],
        'create' => [
            'title'       => 'Admin | Permission | Create',
            'description' => 'Creating a new permission',
        ],
        'edit'   => [
            'title'       => 'Admin | Permission | Edit',
            'description' => 'Editing permission: :name',
        ],
    ],

    'layout'  => [
        'left_sidebar' => [
            'main_menu' => 'Permissions',
        ],
    ],

    'columns' => [
        'id'           => 'ID',
        'name'         => 'Name',
        'display_name' => 'Display name',
        'description'  => 'Description',
        'routes'       => 'Routes',
        'roles'        => 'Roles',
        'created'      => 'Created',
        'updated'      => 'Updated',
        'actions'      => 'Actions',
        'method'       => 'Method',
        'path'         => 'Path',
        'enabled'      => 'Enabled',
    ],

    'action'  => [
        'create'   => 'Create new permission',
        'generate' => 'Generate permissions',
        'reset'    => 'Reset permissions',
    ],

    'content' => [
        'page'         => 'Permission',
        'page-manager' => 'Permission Manager',
        'list'         => 'Permission List',
        'show'         => 'Permission Detail',
        'add'          => 'Permission Add Form',
        'update'       => 'Update Form',
    ],

];
