<?php

return [
    'button' => [
        'add' => 'Add',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],

    'status'              => [
        'created'                   => 'Facility successfully created',
        'updated'                   => 'Facility successfully updated',
        'invalid'                   => 'Invalid request',
        'deleted'                   => 'Facility successfully deleted',
        'enabled'                   => 'Facility enabled.',
        'disabled'                  => 'Facility disabled.',
    ],

    'error'               => [
        'create'                                => 'Error while creating facility.',
        'update'                                => 'Error while updating facility.',
        'enabled'                               => 'Error while enabling facility.',
        'disabled'                              => 'Error while disabling facility.',
    ],

    'page'              => [
        'index'                => [
            'title'             => 'Admin | Admin Facilities | List',
            'page-title'        => 'Facility List Page ',
        ],
        'create'         => [
            'title'                 => 'Admin | Admin Facility | Create',
            'page-title'            => 'Create new facility: '
        ],
        'edit'         => [
            'title'                  => 'Admin | Admin Facility | Edit',
            'page-title'             => 'Edit facility: '
        ],
    ],

    'columns'           => [
        'id'                        =>  'ID',
        'type'                      =>  'Type',
        'province_name'             =>  'Province name',
        'province_code'             =>  'Province code',
        'district_name'             =>  'District name',
        'district_code'             =>  'District code',
        'palika_name'               =>  'Palika name',
        'palika_code'               =>  'Palika code',
        'ward_name'                 =>  'Ward name',
        'ward_code'                 =>  'Ward code',
        'hf_name'                   =>  'Health facility name',
        'hf_type'                   =>  'Health facility type',
        'hf_code'                   =>  'Health facility code',
        'ownership_type'            =>  'Ownership type',
        'urban_rural'               =>  'Urban / Rural',
        'district'                  =>  'District',
        'palika'                    =>  'Palika',
        'health_facility'           =>  'Health facility',
        'geography'                 =>  'Geography',
        'public_nonpublic'          =>  'Public / Nonpublic',
        'status'                    =>  'Status'
    ],

    'action'               => [
        'create'                => 'Create new facility',
        'edit'                  => 'Edit facility',
        'active'                => 'Active',
    ],

    'content' => [
        'page'          => 'Facility',
        'page-manager'  => 'Facility manager',
        'list'          => 'Facility list',
        'show'          => 'Facility detail',
        'add'           => 'Facility add form',
        'update'        => 'Update form',
    ],


    'delete'            =>  [
        'title'                         =>  'Delete facility',
        'sure'                          =>  'Are you sure?',
        'message'                       =>  'You will not be able to undo this!',
        'confirmButtonColor'            =>  '#039BE5',
    ],

];
