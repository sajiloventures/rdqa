<?php
return [

    'status'              => [
        'created'                   => 'User successfully created',
        'updated'                   => 'User successfully updated',
        'deleted'                   => 'User successfully deleted',
        'global-enabled'            => 'Selected users enabled.',
        'global-disabled'           => 'Selected users disabled.',
        'enabled'                   => 'User enabled.',
        'disabled'                  => 'User disabled.',
        'no-user-selected'          => 'No user selected.',
        'invalid-request'           => 'Invalid Request.',
    ],

    'error'               => [
        'cant-be-edited'                => 'User cannot be edited',
        'cant-be-deleted'               => 'User cannot be deleted',
        'cant-be-disabled'              => 'User cannot be disabled',
        'login-failed-user-disabled'    => 'That account has been disabled.',
    ],

    'page'              => [
        'index'              => [
            'title'             => 'Admin | Users',
            'description'       => 'List of users',
        ],
        'show'              => [
            'title'             => 'Admin | User | Show',
            'description'       => 'Displaying user: :full_name',
        ],
        'create'            => [
            'title'            => 'Admin | User | Create',
            'description'      => 'Creating a new user',
        ],
        'edit'              => [
            'title'            => 'Admin | User | Edit',
            'description'      => 'Editing user: :full_name',
        ],
    ],

    'layout'            => [
        'left_sidebar'         => [
            'main_menu'         => 'Users',
        ]
    ],

    'columns'           => [
        'id'                        =>  'ID',
        'username'                  =>  'User name',
        'first_name'                =>  'First name',
        'last_name'                 =>  'Last name',
        'name'                      =>  'Name',
        'roles'                     =>  'Roles',
        'email'                     =>  'Email',
        'password'                  =>  'Password',
        'password_confirmation'     =>  'Password confirmation',
        'created'                   =>  'Created',
        'updated'                   =>  'Updated',
        'actions'                   =>  'Actions',
        'effective'                 =>  'Effective',
        'enabled'                   =>  'Enabled',
        'role'                      => 'Role',
        'description'               => 'Description',
    ],

    'button'               => [
        'create'    =>  'Create new user',
    ],

    'content' => [
        'page'          => 'User',
        'page-manager'  => 'User Manager',
        'list'          => 'User List',
        'show'          => 'User Detail',
        'add'           => 'User Add Form',
        'update'        => 'Update Form'
    ],



];

