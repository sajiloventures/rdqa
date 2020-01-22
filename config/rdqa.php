<?php
return [
    'acl' => [
        'allow_acl_access' => env('ALLOW_ACL_ACCESS', false),
    ],

    'route' => [
        'admin-login' => 'admin-login',
        'admin-logout' => 'admin-logout'
    ],

    'route-prefix' => [
        'admin' => 'demo-admin',
        'spark' => 'demo-spark',
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Paths
    |--------------------------------------------------------------------------
    | All the assets path are to be used form here
    |
    */
    'asset_path' => [
        'admin' => [
            'assets' => 'assets/',
        ],
        'frontend' => [
            'images' => 'images/',
        ],
        'resource_file' => 'resource_file/'
    ],

    'site-configuration-keys' => [
        'ADMIN-PAGINATION-LIMIT' => '10',
        'DOMAIN_NAME' => env('DOMAIN_NAME','http://rdqa.mohp.gov.np/'),
        'EMAIL_ADDRESS' => env('EMAIL_ADDRESS','robinme7@gmail.com'),
        'FB_LINK' => 'http://facebook.com',
        'PHONE' => '000-000-0000',
        'SENDING_EMAIL' => 'robinme7@gmail.com',
        'RECEIVING_EMAIL' => 'robinme7@gmail.com',
        'TWITTER_LINK' => 'https://twitter.com',
        'SEO_TITLE' => 'RDQA',
        'SEO_DESCRIPTION' => 'Routine Data Quality Assessment tool',
        'SEO_KEYWORDS' => 'rdqa, data quality',
        'DEFAULT_FISCAL_MONTH' => 7,
        'COMPANY_NAME' => 'RDQA'
    ],


    // these roles won't be considered in GG Application
    'excluded-roles' => ['admins', 'users'],

    /*
    |--------------------------------------------------------------------------
    | Error Codes
    |--------------------------------------------------------------------------
    |
    */
    'error-codes' => [
        'system-error' => 'system-error',
        'no-error-code-passed' => 'no-error-code-passed',
        'invalid-request' => 'invalid-request',
        'un-authorized-request' => 'un-authorized-request',
        'not-found' => 'not-found',
        'event-not-found' => 'event-not-found',
        'no-role-assigned' => 'no-role-assigned',
        'multiple-role-assigned' => 'multiple-role-assigned',
    ],

    'admin-users-roles' => [
        'super-admin' => [
            'title' => 'Super Admin',
            'key' => 'super-admin',
            'redirect_after_login' => 'admin/dashboard',
            ''
        ],
        'rdqa-admin' => [
            'title' => 'RDQA Admin',
            'key' => 'rdqa-admin',
            'redirect_after_login' => 'admin/dashboard',
        ],
        'province-user' => [
            'title' => 'Province User',
            'key' => 'province-user',
            'redirect_after_login' => 'admin/dashboard',
        ],
        'district-user' => [
            'title' => 'District',
            'key' => 'district-user',
            'redirect_after_login' => 'admin/dashboard',
        ],
        'palika-user' => [
            'title' => 'Palika user',
            'key' => 'palika-user',
            'redirect_after_login' => 'admin/dashboard',
        ],
        'facility-user' => [
            'title' => 'Facility user',
            'key' => 'facility-user',
            'redirect_after_login' => 'admin/dashboard',
        ],
    ],

    'built-stage'   => [
        'stage-1' => [
            'key'           => 'stage-1',
            'title'         => 'Stage 1',
        ],
        'stage-2' => [
            'key'           => 'stage-2',
            'title'         => 'Stage 2',
        ],
        'stage-3' => [
            'key'           => 'stage-3',
            'title'         => 'Stage 3',
        ],
        'stage-4' => [
            'key'           => 'stage-4',
            'title'         => 'Stage 4',
        ],
        'stage-5' => [
            'key'           => 'stage-5',
            'title'         => 'Stage 5',
        ],
    ],

    'question-type' => [
        'part-1'    => [
            'a'             => 'yes-no-remark',
            'b'             => 'ratio',
            'c'             => 'ratio',
        ],
        'part-2'    => 'yes-no-remark',
        'part-3'    => 'remarks',
    ],

    'yes-no'    => [
        3     => 'Yes- completely',
        2     => 'Partly',
        1     => 'No - not at all',
        0     => 'N/A',
    ],

];
