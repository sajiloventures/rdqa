<?php
// Admin Home
Breadcrumbs::register('admin.home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('admin.home'));
//    $breadcrumbs->push('Dashboard', route('admin.users.index'));
});
Breadcrumbs::register('admin.dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('admin.home'));
//    $breadcrumbs->push('Dashboard', route('admin.users.index'));
});

// Users
Breadcrumbs::register('admin.users.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Users', route('admin.users.index'));
});

Breadcrumbs::register('admin.users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push('Add', route('admin.users.index'));
});

Breadcrumbs::register('admin.users.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push('Edit');
});

// Roles
Breadcrumbs::register('admin.roles.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Roles', route('admin.roles.index'));
});

Breadcrumbs::register('admin.roles.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.roles.index');
    $breadcrumbs->push('Add');
});

Breadcrumbs::register('admin.roles.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.roles.index');
    $breadcrumbs->push('Edit');
});

// Permissions
Breadcrumbs::register('admin.permissions.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Permissions', route('admin.permissions.index'));
});

Breadcrumbs::register('admin.permissions.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.permissions.index');
    $breadcrumbs->push('Add');
});

Breadcrumbs::register('admin.permissions.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.permissions.index');
    $breadcrumbs->push('Edit');
});

// Routes
Breadcrumbs::register('admin.routes.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Routes', route('admin.routes.index'));
});

Breadcrumbs::register('admin.routes.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.routes.index');
    $breadcrumbs->push('Add');
});

Breadcrumbs::register('admin.routes.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.routes.index');
    $breadcrumbs->push('Edit');
});

// Configuration
Breadcrumbs::register('admin.configuration', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Configuration', route('admin.configuration'));
});

Breadcrumbs::register('admin.configuration.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.configuration', route('admin.configuration'));
    $breadcrumbs->push('Create');
});

Breadcrumbs::register('admin.configuration.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.configuration', route('admin.configuration'));
    $breadcrumbs->push('Edit');
});

//RDQa

/*   Admin Users */
Breadcrumbs::register('admin.admin_users', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Admin Users');
});

Breadcrumbs::register('admin.admin_users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.admin_users', route('admin.admin_users'));
    $breadcrumbs->push('Add Users');
});

Breadcrumbs::register('admin.admin_users.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.admin_users', route('admin.admin_users'));
    $breadcrumbs->push('Edit Users');
});

/*  End Admin users */

/*   Indicator */
Breadcrumbs::register('admin.indicator', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Indicator');
});

Breadcrumbs::register('admin.indicator.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.indicator', route('admin.indicator'));
    $breadcrumbs->push('Add Indicator');
});

Breadcrumbs::register('admin.indicator.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.indicator', route('admin.indicator'));
    $breadcrumbs->push('Edit Indicator');
});

/*  End Indicator */

/*   Facility */
Breadcrumbs::register('admin.facility', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Facility');
});

Breadcrumbs::register('admin.facility.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.facility', route('admin.facility'));
    $breadcrumbs->push('Add Facility');
});

Breadcrumbs::register('admin.facility.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.facility', route('admin.facility'));
    $breadcrumbs->push('Edit Facility');
});

/*  End Facility */

/*   Instance */
Breadcrumbs::register('admin.instance', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Instance');
});

Breadcrumbs::register('admin.instance.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.instance', route('admin.instance'));
    $breadcrumbs->push('Add Instance');
});

Breadcrumbs::register('admin.instance.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.instance', route('admin.instance'));
    $breadcrumbs->push('Edit Instance');
});

Breadcrumbs::register('admin.instance.deliverySite', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.instance', route('admin.instance'));
    $breadcrumbs->push('Site delivery data');
});

Breadcrumbs::register('admin.instance.deliverySite.view', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.instance', route('admin.instance'));
    $breadcrumbs->push('Graph');
});

/*  End Instance */

/*   Compare sheet */
Breadcrumbs::register('admin.compare_sheet', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Compare sheet');
});

Breadcrumbs::register('admin.compare_sheet.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.compare_sheet', route('admin.compare_sheet'));
    $breadcrumbs->push('Add Compare sheet');
});

Breadcrumbs::register('admin.compare_sheet.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.compare_sheet', route('admin.compare_sheet'));
    $breadcrumbs->push('Edit Compare sheet');
});

/*  End Compare sheet */

/*   Question */
Breadcrumbs::register('admin.question', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Question');
});


/*  End Question */


/*   Settings */
Breadcrumbs::register('admin.user.profile', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('User profile');
});
Breadcrumbs::register('admin.userManual', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('User manual');
});


/*  End Settings */


/*   FAQ */
Breadcrumbs::register('admin.faq', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('FAQ');
});

Breadcrumbs::register('admin.faq.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.faq', route('admin.faq'));
    $breadcrumbs->push('Add FAQ');
});

Breadcrumbs::register('admin.faq.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.faq', route('admin.faq'));
    $breadcrumbs->push('Edit FAQ');
});
/*  End FAQ */


/*   Resource */
Breadcrumbs::register('admin.resource', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.home', route('admin.home'));
    $breadcrumbs->push('Resource');
});

Breadcrumbs::register('admin.resource.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.resource', route('admin.resource'));
    $breadcrumbs->push('Add Resource');
});

Breadcrumbs::register('admin.resource.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.resource', route('admin.resource'));
    $breadcrumbs->push('Edit Resource');
});
/*  End Resource */






