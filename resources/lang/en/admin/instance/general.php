<?php

return [
    'button' => [
        'add' => 'Add',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],

    'status'              => [
        'created'                   => 'Instance successfully created',
        'updated'                   => 'Instance successfully updated',
        'invalid'                   => 'Invalid request',
        'deleted'                   => 'Instance successfully deleted',
        'enabled'                   => 'Instance enabled.',
        'disabled'                  => 'Instance disabled.',
        'delete'                    => 'Instance successfully deleted.',
        'part-1'                    => 'Part 1 data successfully added.',
        'part-2'                    => 'Part 2 data successfully added.',
        'part-3'                    => 'Part 3 data successfully added.',
    ],

    'error'               => [
        'create'                                => 'Error while creating instance.',
        'invalid'                               => 'Please select valid instance for edit.',
        'update'                                => 'Error while updating instance.',
        'enabled'                               => 'Error while enabling instance.',
        'disabled'                              => 'Error while disabling instance.',
        'delete'                                => 'Error while deleting instance.',
        'one-indicator'                         => 'At least one indicator is required.',
        'four-indicator'                        => 'At least four indicators are required.',
        'one-evaluation-team'                   => 'At least one evaluation team is required.',
        'part-1'                                => 'Error while adding part-1 data.',
        'part-2'                                => 'Error while adding part-2 data.',
        'part-3'                                => 'Error while adding part-3 data.',
        'not-valid-part'                        => 'Selected part or instance is invalid.',
    ],

    'page'              => [
        'index'                => [
            'title'             => 'Admin | Admin Instances | List',
            'page-title'        => 'Instance List Page ',
        ],
        'graph'                => [
            'title'             => 'Admin | Admin Graph',
            'page-title'        => 'Graph Page ',
        ],
        'create'         => [
            'title'                 => 'Admin | Admin Instance | Create',
            'page-title'            => 'Create new instance: '
        ],
        'edit'         => [
            'title'                  => 'Admin | Admin Instance | Edit',
            'page-title'             => 'Edit instance: '
        ],
    ],

    'columns'           => [
        'action'                    =>  'Action',
        'address'                   =>  'Address',
        'created_by'                =>  'Created by',
        'cross-check-1'             =>  'Cross check 1',
        'cross-check-2'             =>  'Cross check 2',
        'cross-check-3'             =>  'Cross check 3',
        'date'                      =>  'Date',
        'program'                   =>  'Program',
        'select-program'            =>  'Select program',
        'id'                        =>  'ID',
        'indicator'                 =>  'Indicator',
        'level'                     =>  'Level',
        'name'                      =>  'Instance name',
        'selected-indicators'       =>  'Selected indicators',
        'select-indicators'         =>  'Select indicators',
        'sn'                        =>  'SN',
        'from_date'                 =>  'From date',
        'to_date'                   =>  'To date',
        'completed_stage'           =>  'Completed stage',
        'hf_name'                   =>  'Health facility name',
        'palika_name'               =>  'Palika name',
        'district_name'             =>  'District name',
        'province_name'             =>  'Province name',
    ],

    'basic-info'    => [
        'project-name'              => 'Instance name',
        'facility'                  => 'Select Facility',
        'selected-evaluation-team'  => 'Selected evaluation team',
        'evaluation-team-form'      => 'Evaluation team add form',
        'team-name'                 => 'Name',
        'facility-user'             => 'Select facility user',
        'team-title'                => 'Designation',
        'organization'              => 'Organization',
        'team-email'                => 'Email',
        'team-telephone'            => 'Telephone',
    ],


    'indicator'    => [
        'selected-indicator'        => 'Selected indicator',
        'indicator-form'            => 'Indicator form',
        'select-compare-sheet'      => 'Select compare sheet',
        'select-compare-sheet-1'    => 'Select compare sheet 1',
        'select-compare-sheet-2'    => 'Select compare sheet 2',
        'vs'                        => 'vs',
    ],

    'action'               => [
        'create'                => 'Create new instance',
        'edit'                  => 'Edit instance',
        'active'                => 'Active',
    ],

    'content' => [
        'page'          => 'Instance',
        'page-manager'  => 'Instance manager',
        'list'          => 'Instance list',
        'show'          => 'Instance detail',
        'add'           => 'Instance add form',
        'update'        => 'Update form',
    ],

    'common'    => [
        'select-entry-type'             => 'प्रविष्ट गर्ने भाग छान्नुहोस',
        'complete-all-data-entry'       => 'को यो नियमित तथ्याङ्क परीक्षण पुर्ण रुपमा प्रविष्ट गरिएको छ ?',
    ],


    'delete'            =>  [
        'title'                         =>  'Delete instance',
        'sure'                          =>  'Are you sure?',
        'message'                       =>  'Deleting this instance also deletes previously recorded data and this process is irreversible.',
        'confirmButtonColor'            =>  '#039BE5',
    ],

];
