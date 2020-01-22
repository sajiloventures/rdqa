<?php
/*
 * Menu Schema
 * Copy Paste to create Menu
 * Remove Blank Indexes
 * [
'ul' => [
'li' => [

'dashboard' => [
'display_order' => 1, // Sorting Of Menus
'need_administrative_access' => true, // 'true' means this menu is accessable only to Root User or User Having admin Role
'acl_auth' => ['admin_home'], // these routes must be accessable to current user
'active_if_request_is' => ['admin/dashboard*'], // If current url matches any Url Patterns then set menu as Active
'additional_attr' => [
'style' => '' // Inline css for Menu Li
],
'a' => [
'route' => 'admin_home', // Route to point by the menu
'content' => '<i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span>',
'additional_attr' => [],
],
'sub_menu' => []
],

],
]
];*/


return [
    'ul' => [

        'li' => [

            /* dashboard View */
            'dashboard'            => [
                'display_order'   => 0,
                'acl_auth'        => 'dashboard',
                'active_if_request_is' => ['admin', 'admin/dashboard'],
                'additional_attr' => [
                    'class' => '',
                ],
                'a'               => [
                    'route'           => 'admin.home',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button',
                    ],
                    'icon'            => '<i class="fa fa-lg fa-fw fa-home"></i>',
                    'content'         => 'DASHBOARD',
                ],
            ],
            /* End: dashboard View */
            /* ACL */
            'acl'                 => [
                'display_order'              => 10,
                /*need for only root users*/
                'need_administrative_access' => true,
                'additional_attr'            => [
                    'class' => '',
                ],
                'a'                          => [
                    'route'           => '#',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button',
                    ],
                    'icon'            => '<i class="fa fa-lg fa-fw fa-list"></i>',
                    'content'         => 'ACL',
                ],
                'sub_menu'                   => [
                    'ul' => [
                        'li' => [

                            'user'       => [
                                'display_order'        => 1,
                                'acl_auth'             => ['admin.users.index:GET'],
                                'active_if_request_is' => ['admin/users*'],
                                'additional_attr'      => [
                                    'class' => '',
                                ],
                                'a'                    => [
                                    'route'           => 'admin.users.index',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button',
                                    ],
                                    'content'         => 'USERS',
                                ],
                            ],
                            'role'       => [
                                'display_order'        => 11,
                                'acl_auth'             => ['admin.roles.index:GET'],
                                'active_if_request_is' => ['admin/roles*'],
                                'additional_attr'      => [
                                    'class' => '',
                                ],
                                'a'                    => [
                                    'route'           => 'admin.roles.index',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button',
                                    ],
                                    'content'         => 'ROLES',
                                ],
                            ],
                            'permission' => [
                                'display_order'        => 21,
                                'acl_auth'             => ['admin.permissions.index:GET'],
                                'active_if_request_is' => ['admin/permissions*'],
                                'additional_attr'      => [
                                    'class' => '',
                                ],
                                'a'                    => [
                                    'route'           => 'admin.permissions.index',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button',
                                    ],
                                    'content'         => 'PERMISSION',
                                ],
                            ],
                            'route'      => [
                                'display_order'        => 31,
                                'acl_auth'             => ['admin.routes.index:GET'],
                                'active_if_request_is' => ['admin/routes*'],
                                'additional_attr'      => [
                                    'class' => '',
                                ],
                                'a'                    => [
                                    'route'           => 'admin.routes.index',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button',
                                    ],
                                    'content'         => 'ROUTE',
                                ],
                            ],

                        ],
                    ],
                ],
            ],
            /* End: ACL */

            /* Admin Users */
            'admin-users' => [
                'display_order' => 20,
                'acl_auth' => ['admin.admin_users:GET'],
                'active_if_request_is' => ['admin/admin_users*'],
                'additional_attr' => [
                    'class' => 'sidebar-menu-item',
                ],
                'a' => [
                    'route' => 'admin.admin_users',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button'
                    ],
                    'icon' => '<i class="fa fa-lg fa-fw fa-users"></i>',
                    'content'   => ' Admin Users',
                ]
            ],
            /* End: Admin Users */

            /* Indicator */
            'indicator' => [
                'display_order' => 30,
                'acl_auth' => ['admin.indicator:GET'],
                'active_if_request_is' => ['admin/indicator*'],
                'additional_attr' => [
                    'class' => 'sidebar-menu-item',
                ],
                'a' => [
                    'route' => 'admin.indicator',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button'
                    ],
                    'icon' => '<i class="fa fa-lg fa-fw fa-thumb-tack"></i>',
                    'content'   => ' Indicator',
                ]
            ],
            /* End: Indicator */

            /* Compare sheet */
            'compare_sheet' => [
                'display_order' => 35,
                'acl_auth' => ['admin.compare_sheet:GET'],
                'active_if_request_is' => ['admin/compare_sheet*'],
                'additional_attr' => [
                    'class' => 'sidebar-menu-item',
                ],
                'a' => [
                    'route' => 'admin.compare_sheet',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button'
                    ],
                    'icon' => '<i class="fa fa-lg fa-fw fa-exchange"></i>',
                    'content'   => ' Compare sheet',
                ]
            ],
            /* End: Compare sheet */

            /* Facility */
            'facility' => [
                'display_order' => 36,
                'acl_auth' => ['admin.facility:GET'],
                'active_if_request_is' => ['admin/facility*'],
                'additional_attr' => [
                    'class' => 'sidebar-menu-item',
                ],
                'a' => [
                    'route' => 'admin.facility',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button'
                    ],
                    'icon' => '<i class="fa fa-lg fa-fw fa-university"></i>',
                    'content'   => ' Facility',
                ]
            ],
            /* End: Facility */

            /* Questions */
            'question' => [
                'display_order' => 37,
                'acl_auth' => ['admin.question:GET'],
                'active_if_request_is' => ['admin/question*'],
                'additional_attr' => [
                    'class' => 'sidebar-menu-item',
                ],
                'a' => [
                    'route' => 'admin.question',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button'
                    ],
                    'icon' => '<i class="fa fa-lg fa-fw fa-question-circle"></i>',
                    'content'   => ' Questions',
                ]
            ],
            /* End: Questions */

            /* Instances */
            'instance' => [
                'display_order' => 38,
                'acl_auth' => ['admin.instance:GET'],
                'active_if_request_is' => ['admin/instance*'],
                'additional_attr' => [
                    'class' => 'sidebar-menu-item',
                ],
                'a' => [
                    'route' => 'admin.instance',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button'
                    ],
                    'icon' => '<i class="fa fa-lg fa-fw fa-list"></i>',
                    'content'   => ' Instances',
                ]
            ],
            /* End: Instances */


            /* Settings */
            'setting'                 => [
                'display_order'              => 39,
                'additional_attr'            => [
                    'class' => '',
                ],
                'a'                          => [
                    'route'           => '#',
                    'additional_attr' => [
                        'class' => 'sidebar-menu-button',
                    ],
                    'icon'            => '<i class="fa fa-lg fa-fw fa-gears"></i>',
                    'content'         => 'Settings',
                ],
                'sub_menu'                   => [
                    'ul' => [
                        'li' => [

                            'user' => [
                                'display_order' => 1,
                                'acl_auth' => ['admin.user.profile:GET'],
                                'active_if_request_is' => ['admin/user/profile*'],
                                'additional_attr' => [
                                    'class' => '',
                                ],
                                'a' => [
                                    'route' => 'admin.user.profile',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button'
                                    ],
                                    'icon' => '<i class="fa fa-lg fa-fw fa-user"></i>',
                                    'content'   => ' Update profile',
                                ]
                            ],

                            'faq' => [
                                'display_order' => 2,
                                'acl_auth' => ['admin.faq:GET'],
                                'active_if_request_is' => ['admin/faq*'],
                                'additional_attr' => [
                                    'class' => '',
                                ],
                                'a' => [
                                    'route' => 'admin.faq',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button'
                                    ],
                                    'icon' => '<i class="fa fa-lg fa-fw fa-question"></i>',
                                    'content'   => ' FAQ',
                                ]
                            ],

                            'user-manual' => [
                                'display_order' => 2,
                                'acl_auth' => ['admin.userManual:GET'],
                                'active_if_request_is' => ['admin/user-manual*'],
                                'additional_attr' => [
                                    'class' => '',
                                ],
                                'a' => [
                                    'route' => 'admin.userManual',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button'
                                    ],
                                    'icon' => '<i class="fa fa-lg fa-fw fa-question"></i>',
                                    'content'   => ' User manual',
                                ]
                            ],


                            'resource' => [
                                'display_order' => 3,
                                'acl_auth' => ['admin.resource:GET'],
                                'active_if_request_is' => ['admin/resource*'],
                                'additional_attr' => [
                                    'class' => '',
                                ],
                                'a' => [
                                    'route' => 'admin.resource',
                                    'additional_attr' => [
                                        'class' => 'sidebar-menu-button'
                                    ],
                                    'icon' => '<i class="fa fa-lg fa-fw fa-cloud-download"></i>',
                                    'content'   => ' Resources',
                                ]
                            ],


                        ],
                    ],
                ],
            ],
            /* End: Settings */











//            /* Configuration */
//            'site-configurations' => [
//                'display_order'        => 20,
//                'need_administrative_access' => true,
//                'additional_attr'      => [
//                    'class' => 'sidebar-menu-item',
//                ],
//                'a'                    => [
//                    'route'           => '#',
//                    'additional_attr' => [
//                        'class' => 'sidebar-menu-button',
//                    ],
//                    'content'         => ' <i class="fa fa-lg fa-fw fa-gear"></i> CONFIGURATION',
//                ],
//                'sub_menu'                   => [
//                    'ul' => [
//                        'li' => [
//
//                            'settings'       => [
//                                'display_order'        => 1,
//                                'acl_auth'             => ['admin.settings:GET'],
//                                'active_if_request_is' => ['admin/settings*'],
//                                'additional_attr'      => [
//                                    'class' => '',
//                                ],
//                                'a'                    => [
//                                    'route'           => 'admin.settings',
//                                    'additional_attr' => [
//                                        'class' => 'sidebar-menu-button',
//                                    ],
//                                    'content'         => 'SETTINGS',
//                                ],
//                            ],
//                            'caching'       => [
//                                'display_order'        => 11,
//                                'acl_auth'             => ['admin.caching.index:GET'],
//                                'active_if_request_is' => ['admin/caching*'],
//                                'additional_attr'      => [
//                                    'class' => '',
//                                ],
//                                'a'                    => [
//                                    'route'           => 'admin.caching.index',
//                                    'additional_attr' => [
//                                        'class' => 'sidebar-menu-button',
//                                    ],
//                                    'content'         => 'CACHING',
//                                ],
//                            ],
//
//                        ],
//                    ],
//                ],
//            ],
//            //  End: Configuration
//
//            /* menu */
//            'menu' => [
//                'key' => 'menu',
//                'display_order' => 30,
//                'acl_auth' => ['admin.menu:GET'],
//                'active_if_request_is' => ['admin/menu*'],
//                'additional_attr' => [
//                    'class' => 'sidebar-menu-item',
//                ],
//                'a' => [
//                    'route' => 'admin.menu',
//                    'additional_attr' => [
//                        'class' => 'sidebar-menu-button'
//                    ],
//                    'content' => ' <i class="fa fa-lg fa-fw fa-windows"></i> MENU',
//                ]
//            ],
//            /* End: menu */

            /* Sign Out */
            'sign-out'            => [
                'display_order'   => 100,
                'acl_auth'        => 'logout',
                'additional_attr' => [
                    'class' => 'sidebar-menu-item',
                ],
                'a'               => [
                    'route'           => 'logout',
                    'additional_attr' => [
                        'class'             => 'sidebar-menu-button',
                        'title'             =>  "Sign Out",
                        'data-action'       =>  "userLogout",
                        'data-logout-msg'   =>  "You can improve your security further after logging out by closing this opened browser",
                    ],
                    'icon'            => '<i class="fa fa-lg fa-fw fa-sign-out"></i>',
                    'content'         => 'SIGN OUT',
                ],
            ],
            /* End: Sign Out */



        ],
    ],
];
