<?php

return [

    'status'              => [
        'created'                           => 'Route successfully created',
        'updated'                           => 'Route successfully updated',
        'deleted'                           => 'Route successfully deleted',
        'loaded'                            => 'Successfully loaded :number routes from application.',
        'indiv-perms-assigned'              => 'Individual routes permission assignment saved.',
        'global-perms-assigned'             => 'Selected routes permission assignment saved.',
        'no-permission-changed-detected'    => 'No permission change detected.',
        'global-enabled'                    => 'Selected routes enabled.',
        'global-disabled'                   => 'Selected routes disabled.',
        'enabled'                           => 'Routes enabled.',
        'disabled'                          => 'Routes disabled.',
        'no-route-selected'                 => 'No route selected.',
    ],

    'error'               => [
        'cant-delete-this-role'  => 'This role cannot be deleted',
        'cant-edit-this-role'    => 'This role cannot be edited',
        'cant-delete-this-route'   => 'This route cannot be deleted',
    ],

    'page'              => [
        'index'              => [
            'title'             => 'Admin | Routes',
            'description'       => 'List of routes',
        ],
        'show'              => [
            'title'             => 'Admin | Route | Show',
            'description'       => 'Displaying route',
        ],
        'create'            => [
            'title'            => 'Admin | Route | Create',
            'description'      => 'Creating a new route',
        ],
        'edit'              => [
            'title'            => 'Admin | Route | Edit',
            'description'      => 'Editing route',
        ],
    ],

    'layout'            => [
        'left_sidebar'         => [
            'main_menu'         => 'Routes',
        ]
    ],

    'columns'           => [
        'id'                        =>  'ID',
        'name'                      =>  'Name',
        'action_name'               =>  'Action name',
        'method'                    =>  'Method',
        'path'                      =>  'Path',
        'permission'                =>  'Permission',
        'slug'                      =>  'Slug',
        'created'                   =>  'Created',
        'updated'                   =>  'Updated',
        'actions'                   =>  'Actions',
        'enabled'                   =>  'Enabled',
    ],

    'action'               => [
        'load-routes'           => 'Load routes from Laravel routes table',
        'reset-routes'          => 'Reset routes and associated routes',
        'create'                => 'Create new route',
        'enable-selected'       => 'Enable selected route',
        'disable-selected'      => 'Disable selected route',
        'save-perms-assignment' => 'Save permission assignments',
    ],

    'content' => [
        'page'          => 'Route',
        'page-manager'  => 'Route Manager',
        'list'          => 'Route List',
        'show'          => 'Route Detail',
        'add'           => 'Route Add Form',
        'update'        => 'Update Form'
    ],



];
