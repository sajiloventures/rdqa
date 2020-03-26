<?php

return [
    'button' => [
        'add' => 'Add',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'verify_by_email' => 'Verify by email',
        'verify_email_sent' => 'Email sent :count',
    ],

    'status'              => [
        'ac_created_in_stripe'      => 'Account created successfully.',
        'ac_verification_email_sent' => 'Account verification request email sent to " :name "',
        'created'                   => 'User successfully created',
        'updated'                   => 'User successfully updated',
        'invalid'                   => 'Invalid request',
        'deleted'                   => 'User successfully deleted',
        'enabled'                   => 'User enabled.',
        'disabled'                  => 'User disabled.',
        'image_size_error'          => 'File size must be less than ',
    ],

    'error'               => [
        'cant-delete-this-User'                 => 'This user cannot be deleted',
        'cant-delete-perm-in-use'               => 'This user is in use',
        'cant-edit-this-User'                   => 'This user cannot be edited',
        'select-valid-user'                     => 'Please Select valid user',
        'super-admin'                           => 'Super admin cannot be created.',
        'ticket-user-email-exist'               => 'That user already exists, please add a new one.',
        'user-not-defined'                      => 'User type not defined.',
        'create'                                => 'Error while creating user.',
        'update'                                => 'Error while updating user.',
        'enabled'                               => 'Error while enabling user.',
        'disabled'                              => 'Error while disabling user.',
    ],

    'page'              => [
        'index'                => [
            'title' => 'Admin | Admin Users | List',
            'page-title' => 'Promoter List Page ',
        ],
        'create'         => [
            'title'                 => 'Admin | Admin User | Create',
            'page-title'          => 'Create new user: '
        ],
        'edit'         => [
            'title'             => 'Admin | Admin User | Edit',
            'page-title'             => 'Edit user: '
        ],
        'bank_ac_verification_form'         => [
            'title'             => 'Admin | Bank Verification',
            'page-title'             => 'Bank verification'
        ],

        'email-template' => [
            'click-here-to-login'           => 'Click here to login',
            'email'                         => 'Email address:',
            'giveback'                      => 'Giveback',
            'giveback-tickets'              => 'Giveback Tickets',
            'login-detail'                  => 'Login information',
            'name'                          => 'Dear :full_name,',
            'password'                      => 'Password:',
            'tickets'                       => 'Tickets',
            'user-add-template-title'       => 'User information',
            'your-login-details'            => 'Welcome to Giveback Tickets! Please log in with the following details:',
          ],
    ],

    'columns'           => [
        'id'                        =>  'ID',
        'assign_for'                =>  'Assigned For',
        'image'                     =>  'Image',
        'name'                      =>  'Name',
        'user-code'                 =>  'User code',
        'email'                     =>  'Email',
        'username'                  =>  'Username',
        'gender'                    =>  'Gender',
        'user_role'                 =>  'User role',
        'actions'                   =>  'Actions',
        'province'                  =>  'Province',
        'district'                  =>  'District',
        'municipality'              =>  'Municipality',
        'health_post_name'          =>  'Health facility',
        'user-status'               =>  'User status',
        'palika_user'               =>  'Select palika user',
        'province_user'             =>  'Select province user',
        'district_user'             =>  'Select district user',
        'parent_user'               =>  'Palika user',
        'status'                    =>  'Status'
    ],

    'action'               => [
        'create'                => 'Create new user',
        'edit'                  => 'Edit user',
        'active'                => 'Active',
        'select_image'          => 'Select image',
        'verified_user'         => 'Verified user',
    ],

    'content' => [
        'page'          => 'User',
        'page-manager'  => 'User manager',
        'list'          => 'User list',
        'show'          => 'User detail',
        'add'           => 'User add form',
        'update'        => 'Update form',
        'select-user-role' => 'Select user role type',

        'list_by'       => 'By',
    ],

    'tab'    =>  [
        'basic'         => [
            'auto-generated-pswd'   => 'A new password has been generated and an email will be sent to this user.',
            'company'               =>  'Company',
            'company_website'       =>  'Company website',
            'title'                 =>  'Basic',
            'select-promoter'       =>  'Select promoter',
            'first-name'            =>  'First name',
            'middle-name'           =>  'Middle name',
            'last-name'             =>  'Last name',
            'dob'                   =>  'Date of birth',
            'gender'                =>  'Gender',
            'address-1'             =>  'Address 1',
            'address-2'             =>  'Address 2',
            'password'              =>  'Password',
            'confirm-password'      =>  'Confirm password',
            'male'                  =>  'Male',
            'female'                =>  'Female',
            'other'                 =>  'Other'
        ],
        'fee'           => [
            'title'                 =>  'Fee',
            'convenience_fee'       => 'Convenience fee',
            'custom-fee'             => 'Custom fee',
            'fee-type'              =>  'Fee type',
            'price-order'           =>  'Price/order',
            '$-order'               =>  '$/order',
            'per-order'             =>  'Percentage/order',
            '%-order'               =>  '%/order',
            'price-ticket'          =>  'Price/ticket',
            '$-ticket'              =>  '$/ticket',
            'per-ticket'            =>  'Percentage/ticket',
            '%-ticket'              =>  '%/ticket',
        ],
        'account'       =>  [
            'title'                 =>  'Account',
            'acc-name'              =>  'Account name',
            'acc-no'                =>  'Account number',
        ],
        'assign_events' => [
            'title'                 => 'Assign events',
        ],
    ],
    
    'delete'            =>  [
        'title'                         =>  'Delete User',
        'sure'                          =>  'Are you sure?',
        'message'                       =>  'You will not be able to undo this!',
        'confirmButtonColor'            =>  '#039BE5',
    ],

    'email' => [
        'user_verification_email' => [
            'title' => 'Givebacktickets',
            'giveback' => 'Giveback',
            'tickets' => 'Tickets',
            'subject' => 'Giveback Tickets is sending you money! Please verify your account.',
            'greeting' => 'Dear :name,',
            'click_here' => 'Click here',
            'par_1' => "Good news! You've been added to Giveback Tickets as a recipient/payee. 
                        This means that Giveback Tickets is sending funds to you or your organization. 
                        Before you can receive electronic funds transfers you will need to complete some simple 
                        verification steps. Please click this link to start the verification process: :link",
            'par_2' => "Please note that you will be asked to enter banking information for Electronic Funds Transfers, 
                        as well as personal information, so our bank may verify you or someone associated with 
                        your company's bank account. Verification may require a legal company name, date of birth, 
                        address, or other information. Please have this information ready before starting the 
                        verification process.",
            'par_3' => "If you have any questions about the verification or payment process, please email 
                        payments@givebacktickets.com. We take privacy and security seriously, so if you feel you've 
                        received this email mistakenly, please let us know immediately.",
            'regards' => 'Regards',
            'team' => 'The Giveback Tickets Support Team'
        ],
        'user_verified_email' => [
            'title' => 'Givebacktickets',
            'giveback' => 'Giveback',
            'tickets' => 'Tickets',
            'subject' => 'Your verification information has been submitted.',
            'greeting' => 'Dear :name,',
            'click_here' => 'Click here',
            'par_1' => "Thank you for submitting your verification information on Giveback Tickets. 
                        Your account has been verified so you are now set to receive electronic transfers.",
            'par_2' => "If you have any questions please email <a href='mailto:payments@givebacktickets.com'>payments@givebacktickets.com</a>.",
            'par_3' => "We take privacy and security seriously, so if you feel you've received this email mistakenly, please let us know immediately.",
            'regards' => 'Regards',
            'team' => 'The Giveback Tickets Support Team'
        ],
    ],
];
