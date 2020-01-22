<?php
return [

    'index'                => [
        'title'       => 'Admin | Settings',
        'description' => 'List of Settings',
    ],

    'show'                 => [
        'title'       => 'Admin | Settings | Show',
        'description' => 'Displaying Settings: :full_name',
    ],
    'create'               => [
        'title'       => 'Admin | Settings | Create',
        'description' => 'Creating a new Settings',
    ],
    'edit'                 => [
        'title'       => 'Admin | Settings | Edit',
        'description' => 'Editing Settings: :full_name',
    ],
    'reffer'               => [
        'title'       => 'Admin | Settings | Reffers',
        'description' => 'List of reffers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Language Lines
    |--------------------------------------------------------------------------
     */

    'send_email'           => 'Send email to set password',
    'organization'         => 'Organization',
    'adminorganization'    => 'Admin of organization',
    'location'             => 'Location',
    'adminlocation'        => 'Admin of location',
    'credit_card_required' => 'Credit cardrequired',
    'trial_bookings'       => 'Total free classes',
    'title'                => 'Delete activity',
    'body'                 => 'Are you sure that you want to delete Settings ID :id with the name ":full_name"? This operation is irreversible.',

    'status'               =>
        [
            'created'              => 'Settings successfully created',
            'updated'              => 'Settings successfully updated',
            'deleted'              => 'Settings successfully deleted',
            'global-enabled'       => 'Selected Settings enabled.',
            'global-disabled'      => 'Selected Settings disabled.',
            'enabled'              => 'Settings enabled.',
            'disabled'             => 'Settings disabled.',
            'no-Settings-selected' => 'No Settings selected.',
            'invalid-request'      => 'Invalid Request.',
            'imageinfo'            => 'Upload your image here.',
            'both'                 => 'Received both percent off and amount off parameters. Please pass in only one.',
            'send'                 => 'Messages was sent successfully!',
        ],

    'error'                => [
        'cant-be-edited'                 => 'Settings cannot be edited',
        'cant-be-deleted'                => 'Settings cannot be deleted',
        'cant-be-disabled'               => 'Settings cannot be disabled',
        'login-failed-Settings-disabled' => 'That account has been disabled.',
    ],

    'page'                 => [
        'list'   => 'Settings list',
        'index'  => [
            'title'       => 'Admin | Settings',
            'description' => 'List of Settings',
        ],
        'show'   => [
            'title'       => 'Admin | Settings | Information',
            'description' => 'Displaying Settings: :full_name',
        ],
        'create' => [
            'title'       => 'Admin | Settings | Create',
            'description' => 'Creating a new Settings',
        ],
        'edit'   => [
            'title'       => 'Admin | Settings | Edit',
            'description' => 'Editing Settings: :full_name',
        ],
    ],

    'layout'               => [
        'left_sidebar' => [
            'main_menu' => 'Settings',
        ],
    ],

    'content'              => [

        'list'              => 'Settings List',
        'show'              => 'Settings Information',
        'add'               => 'Settings Add Form',
        'update'            => 'Update ',
        'create'            => 'Create ',
        'edit'              => 'Edit ',
        'detail'            => ' Detail',
        'bleuser'           => 'BLE User List',

        'stripe_code'       => 'Stripe Settings Code',
        'code'              => 'Settings Code',
        'first_month'       => 'First Month',
        'following_month'   => 'Following Months',
        'plan_id'           => 'Plan ID',
        'percent_off'       => 'Percent Off',
        'amount_off'        => 'Amount Off',
        'duration'          => 'Duration',
        'redeem_by'         => 'Redeem By',
        'max_redemptions'   => 'Max Redemptions',

        'datetime'          => 'Settings Date',
        'cost'              => 'Settings Cost',
        'attendee'          => 'Attendee Limit',
        'page'              => 'Settings',
        'page-manager'      => 'Settings Manager',
        'title'             => 'Settings Title',
        'date'              => 'Settings Date',
        'short_description' => 'Short Description',
        'description'       => ' Description',
        'status'            => 'Status',

        'type'              => 'Type',
        'action_url'              => 'Action Url',

    ],
    'button'               => [
        'create'  => 'Create new Settings',
        'edit'    => 'Edit Settings',
        'save'    => 'Save Settings',
        'enable'  => 'Enable Settings',
        'disable' => 'Disable Settings',
        'checkin' => 'BLE Check-Ins',
    ],

    'announcement'         => [
        'title'       => 'Admin | Announcement',
        'list'        => 'Announcement List',
        'description' => 'List of Announcement',
        'create' => 'Create Announcement',
    ],
    /*email sections*/
    'email'         => [
        'title'       => 'Admin | Emails',
        'show'        => 'Email Send',
        'description' => 'Email Descriptions',
        'organization' => 'Organization',
        'send_to' => 'Send To',
        'subject' => 'Subject',
        'message' => 'Message',
        'all' => 'All',
        'admins' => 'Admins only',
        'non-admins' => 'Non-Admins Only',
    ],

];
