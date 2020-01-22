<?php
$permission_tree = [

    /*
    |--------------------------------------------------------------------------
    | Route Group
    |--------------------------------------------------------------------------
    | Group Routes so Permissions can be shown Grouped in Role ADD and UPDATE
    | Form
    | 
    | Every routes MUST be listed here
    |
    */
    'route-groups' => [

        'admin' => [
            'section' => [
                'name' => 'Admin Section',
                'description' => '',
            ],
            'groups' => [
                /* User Manager */
                'users' => [
                    /*
                    |--------------------------------------------------------------------------
                    | Section Name
                    |--------------------------------------------------------------------------
                    | Used to show section name in Role Permission Manager page
                    |
                    */
                    'section' => [
                        'name' => 'User Manager',
                        'description' => '',
                        'routes' => [
                            'list' => 'List Users',
                            'view' => 'View Users',
                            'store' => 'Create Users',
                            'update' => 'Update Users',
                            'destroy' => 'Remove Users',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.users.index:GET',
                        ],
                        'view' => [
                            'admin.users.show:GET'
                        ],
                        'store' => [
                            'admin.users.create:GET',
                            'admin.users.store:POST',
                        ],
                        'update' => [
                            'admin.users.edit:GET',
                            'admin.users.update:POST',
                            'admin.users.enable-selected:POST',
                            'admin.users.disable-selected:POST',
                            'admin.users.enable:GET',
                            'admin.users.disable:GET'
                        ],
                        'destroy' => [
                            'admin.users.confirm-delete:GET',
                            'admin.users.delete:GET',
                        ],
                    ],
                ],

                /* Role Manager */
                'roles' => [
                    'section' => [
                        'name' => 'Role Manager',
                        'routes' => [
                            'list' => 'List Role',
                            'view' => 'View Role',
                            'store' => 'Create Role',
                            'update' => 'Update Role',
                            'destroy' => 'Remove Role',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.roles.index:GET',
                        ],
                        'view' => [
                            'admin.roles.show:GET'
                        ],
                        'store' => [
                            'admin.roles.create:GET',
                            'admin.users.search:POST',
                            'admin.users.get-info:POST',
                            'admin.roles.store:POST',
                        ],
                        'update' => [
                            'admin.roles.edit:GET',
                            'admin.users.search:POST',
                            'admin.users.get-info:POST',
                            'admin.roles.update:POST',
                            'admin.roles.enable-selected:POST',
                            'admin.roles.disable-selected:POST',
                            'admin.roles.enable:GET',
                            'admin.roles.disable:GET'
                        ],
                        'destroy' => [
                            'admin.roles.confirm-delete:GET',
                            'admin.roles.delete:GET',
                        ],
                    ],
                ],

                /* Permission Manager */
                'permissions' => [
                    'section' => [
                        'name' => 'Permission Manager',
                        'routes' => [
                            'list' => 'List Permission',
                            'view' => 'View Permission',
                            'store' => 'Create Permission',
                            'update' => 'Update Permission',
                            'destroy' => 'Remove Permission',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.permissions.index:GET',
                            'admin.permissions.generate:GET',
                        ],
                        'view' => [
                            'admin.permissions.show:GET'
                        ],
                        'store' => [
                            'admin.permissions.create:GET',
                            'admin.routes.save-perms:POST',
                            'admin.routes.search:GET',
                            'admin.routes.get-info:POST',
                            'admin.permissions.store:POST',
                        ],
                        'update' => [
                            'admin.permissions.edit:GET',
                            'admin.routes.save-perms:POST',
                            'admin.routes.search:GET',
                            'admin.routes.get-info:POST',
                            'admin.permissions.update:POST',
                            'admin.permissions.enable-selected:POST',
                            'admin.permissions.disable-selected:POST',
                            'admin.permissions.enable:GET',
                            'admin.permissions.disable:GET'
                        ],
                        'destroy' => [
                            'admin.permissions.confirm-delete:GET',
                            'admin.permissions.delete:GET',
                        ],
                    ],
                ],

                /* Route Manager */
                'routes' => [
                    'section' => [
                        'name' => 'Route Manager',
                        'routes' => [
                            'list' => 'List Route',
                            'view' => 'View Route',
                            'store' => 'Create Route',
                            'update' => 'Update Route',
                            'destroy' => 'Remove Route',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.routes.index:GET',
                            'admin.routes.load:GET',
                        ],
                        'view' => [
                            'admin.routes.show:GET'
                        ],
                        'store' => [
                            'admin.routes.create:GET',
                            'admin.routes.store:POST',
                        ],
                        'update' => [
                            'admin.routes.edit:GET',
                            'admin.routes.update:POST',
                            'admin.routes.enable-selected:POST',
                            'admin.routes.disable-selected:POST',
                            'admin.routes.enable:GET',
                            'admin.routes.disable:GET'
                        ],
                        'destroy' => [
                            'admin.routes.confirm-delete:GET',
                            'admin.routes.delete:GET',
                        ],
                    ],
                ],

                /* Configuration Manager */
                'configuration' => [
                    'section' => [
                        'name' => 'Config Manager',
                        'routes' => [
                            'list' => 'List Config',
                            'store' => 'Create Config',
                            'update' => 'Update Config',
                            'destroy' => 'Remove Config',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.configuration:GET',
                            'admin.configuration.search:POST',
                        ],
                        'store' => [
                            'admin.configuration.create:GET',
                            'admin.configuration.store:POST',
                        ],
                        'update' => [
                            'admin.configuration.edit:GET',
                            'admin.configuration.update:POST',
                            'admin.configuration.enableAll:POST',
                            'admin.configuration.disableAll:POST',
                            'admin.configuration.enable:GET',
                            'admin.configuration.disable:GET'
                        ],
                        'destroy' => [
                            'admin.configuration.confirm-delete:GET',
                            'admin.configuration.delete:POST',
                        ],
                    ],
                ],

                /* Setting Manager */
                'setting' => [
                    'section' => [
                        'name' => 'Setting Manager',
                        'routes' => [
                            'list' => 'List Setting',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.settings:GET',
                            'admin.settings.basic:POST',
                            'admin.settings.smtp:POST',
                            'admin.settings.social:POST',
                        ],
                    ],
                ],


                /* Page Manager */
                'page' => [
                    'section' => [
                        'name' => 'Page Manager',
                        'routes' => [
                            'list' => 'List Pages',
                            'store' => 'Create Pages',
                            'update' => 'Update Pages',
                            'destroy' => 'Remove Pages',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.page:GET',
                            'admin.page.search:POST',
                        ],
                        'store' => [
                            'admin.page.create:GET',
                            'admin.page.store:POST',
                        ],
                        'update' => [
                            'admin.page.edit:GET',
                            'admin.page.update:POST',
                            'admin.page.enable-page:POST',
                            'admin.page.check-slug:POST',
                            'admin.page.getDescriptionViewModal:GET',
                            'admin.page.enable:GET',
                            'admin.page.disable:GET',
                            'admin.page.enableAll:POST',
                            'admin.page.disableAll:POST',
                        ],
                        'destroy' => [
                            'admin.page.confirm-delete:GET',
                            'admin.page.delete:POST',
                        ],
                    ],
                ],
                
                /* Menu Manager */
                'menu' => [
                    'section' => [
                        'name' => 'Menu Manager',
                        'routes' => [
                            'list' => 'List Menus',
                            'store' => 'Create Menu',
                            'update' => 'Update Menus',
                            'destroy' => 'Remove Menus',
                            'pagesManage' => 'Manage Pages For Menu',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.menu:GET',
                        ],
                        'store' => [
                            'admin.menu.create:GET',
                            'admin.menu.store:POST',
                        ],
                        'update' => [
                            'admin.menu.edit:GET',
                            'admin.menu.update:POST',
                            'admin.menu.enable-page:POST',
                            'admin.menu.check-slug:POST',
                            'admin.menu.enable:GET',
                            'admin.menu.disable:GET',
                            'admin.menu.enableAll:POST',
                            'admin.menu.disableAll:POST',
                        ],
                        'destroy' => [
                            'admin.menu.confirm-delete:GET',
                            'admin.menu.delete:GET',
                            'admin.menu.confirm-bulk-delete:GET',
                            'admin.menu.delete-all:POST',
                        ],
                        'pagesManage' => [
                            'admin.api.page.show:GET',
                            'admin.api.page.update:POST',
                            'admin.api.page.updatePageDetails:POST'.
                            'admin.api.page.enableOrDisablePage:POST',
                        ],
                    ],
                ],

                'admin-dashboard' => [
                    'section' => [
                        'name' => 'Dashboard',
                        'routes' => [
                            'list' => 'dashboard',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.home:GET',
                        ],
                    ],
                ],


                'user-profile' => [
                    'section' => [
                        'name' => 'Update profile',
                        'routes' => [
                            'update' => 'Update profile',
                        ],
                    ],
                    'routes' => [
                        'update' => [
                            'admin.user.profile:GET',
                            'admin.user.profile.update:POST',
                        ],
                    ],
                ],

                /* Admin Users Manager */
                'admin_users' => [
                    'section' => [
                        'name' => 'Admin User Manager',
                        'routes' => [
                            'list' => 'List admin users',
                            'store' => 'Create new user',
                            'update' => 'Update admin user data',
                            'impersonate' => 'Impersonate',
                            'destroy' => 'Remove admin user',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.admin_users:GET',
                            'admin.admin_users.search:POST'
                        ],
                        'store' => [
                            'admin.admin_users.create:GET',
                            'admin.admin_users.store:POST',
                            'admin.admin_users.address:GET',
                            'admin.instance.facility:GET',
                            'admin.admin_users.roles:GET',
                        ],
                        'update' => [
                            'admin.admin_users.edit:GET',
                            'admin.admin_users.update:POST',
                            'admin.admin_users.enable:GET',
                            'admin.admin_users.disable:GET',
                            'admin.admin_users.address:GET',
                            'admin.instance.facility:GET',
                            'admin.admin_users.roles:GET',
                        ],
                        'impersonate' => [
                            'admin.users.impersonate:GET',
                            'admin.users.stop:GET',
                        ],
                        'destroy' => [
                            'admin.admin_users.delete:GET'
                        ],
                    ],
                ],

                /* Indicator Manager */
                'indicator' => [
                    'section' => [
                        'name' => 'Indicator Manager',
                        'routes' => [
                            'list' => 'List indicators',
                            'store' => 'Create new indicator',
                            'update' => 'Update indicator data',
                            'destroy' => 'Remove indicator',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.indicator:GET',
                            'admin.indicator.search:POST'
                        ],
                        'store' => [
                            'admin.indicator.create:GET',
                            'admin.indicator.store:POST',
                        ],
                        'update' => [
                            'admin.indicator.edit:GET',
                            'admin.indicator.update:POST',
                            'admin.indicator.enable:GET',
                            'admin.indicator.enable_all:GET',
                            'admin.indicator.disable:GET',
                        ],
                        'destroy' => [
                            'admin.indicator.delete:GET'
                        ],
                    ],
                ],

                /* End: Indicator Manager */

                /* Compare sheet Manager */
                'compare_sheet' => [
                    'section' => [
                        'name' => 'Compare sheet Manager',
                        'routes' => [
                            'list' => 'List compare_sheets',
                            'store' => 'Create new compare_sheet',
                            'update' => 'Update compare_sheet data',
                            'destroy' => 'Remove compare_sheet',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.compare_sheet:GET',
                            'admin.compare_sheet.search:POST'
                        ],
                        'store' => [
                            'admin.compare_sheet.create:GET',
                            'admin.compare_sheet.store:POST',
                        ],
                        'update' => [
                            'admin.compare_sheet.edit:GET',
                            'admin.compare_sheet.update:POST',
                            'admin.compare_sheet.enable:GET',
                            'admin.compare_sheet.disable:GET',
                        ],
                        'destroy' => [
                            'admin.compare_sheet.delete:GET'
                        ],
                    ],
                ],

                /* End: Compare sheet Manager */

                /* Facility Manager */
                'facility' => [
                    'section' => [
                        'name' => 'Facility Manager',
                        'routes' => [
                            'list' => 'List facilities',
                            'store' => 'Create new facility',
                            'update' => 'Update facility data',
                            'destroy' => 'Remove facility',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.facility:GET',
                            'admin.facility.search:POST'
                        ],
                        'store' => [
                            'admin.facility.create:GET',
                            'admin.facility.store:POST',
                        ],
                        'update' => [
                            'admin.facility.edit:GET',
                            'admin.facility.update:POST',
                            'admin.facility.enable:GET',
                            'admin.facility.disable:GET',
                        ],
                        'destroy' => [
                            'admin.facility.delete:GET'
                        ],
                    ],
                ],

                /* End: Facility Manager */

                /* Question Manager */
                'question' => [
                    'section' => [
                        'name' => 'Question Manager',
                        'routes' => [
                            'list' => 'List questions',
                            'edit_title' => 'Edit question format title',
                            'add_question' => 'Add update question to question format',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.question:GET',
                        ],
                        'edit_title' => [
                            'admin.question.getEditModal:POST',
                            'admin.question.updateTitle:POST',
                        ],
                        'add_question' => [
                            'admin.question.getAddQuestionModal:POST',
                            'admin.question.addUpdateQuestions:POST',
                        ],
                    ],
                ],

                /* End: Question Manager */

                /* Instance Manager */
                'instance' => [
                    'section' => [
                        'name' => 'Instance Manager',
                        'routes' => [
                            'list' => 'List instances',
                            'create' => 'Create instances',
                            'edit' => 'Edit instance',
                            'destroy' => 'Delete instance',
                            'site_delivery' => 'Add update site delivery data',
                            'view_graph' => 'View each instance graph',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.instance:GET',
                            'admin.instance.search:POST',
                        ],
                        'create' => [
                            'admin.instance.create:GET',
                            'admin.instance.facility:GET',
                            'admin.instance.indicator:GET',
                            'admin.instance.store:POST',
                        ],
                        'edit' => [
                            'admin.instance.edit:GET',
                            'admin.instance.facility:GET',
                            'admin.instance.indicator:GET',
                            'admin.instance.update:POST',
                        ],
                        'destroy'    => [
                            'admin.instance.destroy:GET',
                        ],
                        'site_delivery' => [
                            'admin.instance.deliverySite:GET',
                            'admin.instance.deliverySite.partOne.store:POST',
                            'admin.instance.deliverySite.partTwo.store:POST',
                            'admin.instance.deliverySite.partThree.store:POST',
                        ],
                        'view_graph'    => [
                            'admin.instance.deliverySite.view:GET',
                        ],
                    ],
                ],

                /* End: Instance Manager */

                /* FAQ Manager */
                'faq' => [
                    'section' => [
                        'name' => 'FAQ Manager',
                        'routes' => [
                            'list' => 'List faqs',
                            'store' => 'Create faqs',
                            'update' => 'Edit faq',
                            'delete' => 'Delete faq',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.faq:GET',
                        ],
                        'store' => [
                            'admin.faq.create:GET',
                            'admin.faq.store:POST',
                        ],
                        'update' => [
                            'admin.faq.edit:GET',
                            'admin.faq.enable:GET',
                            'admin.faq.disable:GET',
                            'admin.faq.sortData:POST',
                            'admin.faq.update:POST',
                        ],
                        'delete'    => [
                            'admin.faq.delete:GET',
                        ],
                    ],
                ],

                /* End: FAQ Manager */

                /* Resource Manager */
                'resource' => [
                    'section' => [
                        'name' => 'Resource Manager',
                        'routes' => [
                            'list' => 'List resources',
                            'store' => 'Create resources',
                            'update' => 'Edit resource',
                            'delete' => 'Delete resource',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.resource:GET',
                            'admin.resource.search:POST',
                        ],
                        'store' => [
                            'admin.resource.create:GET',
                            'admin.resource.store:POST',
                            'admin.resource.upload:POST',
                        ],
                        'update' => [
                            'admin.resource.edit:GET',
                            'admin.resource.enable:GET',
                            'admin.resource.disable:GET',
                            'admin.resource.update:POST',
                            'admin.resource.upload:POST',
                        ],
                        'delete'    => [
                            'admin.resource.delete:GET',
                        ],
                    ],
                ],

                /* End: Resource Manager */

                /* User Manual Manager */
                'user-manual' => [
                    'section' => [
                        'name' => 'User Manual Manager',
                        'routes' => [
                            'list' => 'User manual',
                        ],
                    ],
                    'routes' => [
                        'list' => [
                            'admin.userManual:GET',
                            'admin.userManual.store:POST',
                        ],
                    ],
                ],

                /* End: User Manual Manager */

            ],
        ],

    ],


];


// MERGE external route to App Route Permissions

/*******************************************
 ***** routes for File Manager *************
 ******************************************/
$unisharp = [
    'unisharp.lfm.show:GET',
    'unisharp.lfm.getErrors:GET',
    'unisharp.lfm.upload:GET',
    'unisharp.lfm.upload:POST',
    'unisharp.lfm.upload:PUT',
    'unisharp.lfm.upload:PATCH',
    'unisharp.lfm.upload:DELETE',
    'unisharp.lfm.upload:OPTIONS',
    'unisharp.lfm.getItems:GET',
    'unisharp.lfm.getAddfolder:GET',
    'unisharp.lfm.getDeletefolder:GET',
    'unisharp.lfm.getFolders:GET',
    'unisharp.lfm.getCrop:GET',
    'unisharp.lfm.getCropimage:GET',
    'unisharp.lfm.getRename:GET',
    'unisharp.lfm.getResize:GET',
    'unisharp.lfm.performResize:GET',
    'unisharp.lfm.getDownload:GET',
    'unisharp.lfm.getDelete:GET',
    'unisharp.lfm.:GET',
];

// Questions
$permission_tree['route-groups']['admin']['groups']['faq']['routes']['store'] = array_merge($permission_tree['route-groups']['admin']['groups']['faq']['routes']['store'], $unisharp);
$permission_tree['route-groups']['admin']['groups']['faq']['routes']['update'] = array_merge($permission_tree['route-groups']['admin']['groups']['faq']['routes']['update'], $unisharp);

// User manual
$permission_tree['route-groups']['admin']['groups']['user-manual']['routes']['list'] = array_merge($permission_tree['route-groups']['admin']['groups']['user-manual']['routes']['list'], $unisharp);

return $permission_tree;