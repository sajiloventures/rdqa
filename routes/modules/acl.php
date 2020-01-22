<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 12/11/17
 * Time: 12:53 PM
 */
// Routes in this group must be authorized.
Route::group(['middleware' => 'authorize'], function () {
    /*****************Start ACL*****************************/
//UserController routes
    Route::get('users',                                         ['as' => 'users.index',                     'uses' => 'Admin\Acl\UsersController@index']);
    Route::get('users/create',                                  ['as' => 'users.create',                    'uses' => 'Admin\Acl\UsersController@create']);
    Route::post('users/store',                                  ['as' => 'users.store',                     'uses' => 'Admin\Acl\UsersController@store']);
    Route::get('users/show/{userId}',                           ['as' => 'users.show',                      'uses' => 'Admin\Acl\UsersController@show']);
    Route::get('users/{userId}/edit',                           ['as' => 'users.edit',                      'uses' => 'Admin\Acl\UsersController@edit']);
    Route::post('users/{userId}/update',                        ['as' => 'users.update',                    'uses' => 'Admin\Acl\UsersController@update']);
    Route::post('users/enableSelected',                         ['as' => 'users.enable-selected',           'uses' => 'Admin\Acl\UsersController@enableSelected']);
    Route::post('users/disableSelected',                        ['as' => 'users.disable-selected',          'uses' => 'Admin\Acl\UsersController@disableSelected']);
// Route::resource('users', 'Admin\Acl\UsersController');
    Route::get('users/{userId}/confirm-delete',                 ['as' => 'users.confirm-delete',            'uses' => 'Admin\Acl\UsersController@getModalDelete']);
    Route::get('users/{userId}/delete',                         ['as' => 'users.delete',                    'uses' => 'Admin\Acl\UsersController@destroy']);
    Route::get('users/{userId}/enable',                         ['as' => 'users.enable',                    'uses' => 'Admin\Acl\UsersController@enable']);
    Route::get('users/{userId}/disable',                        ['as' => 'users.disable',                   'uses' => 'Admin\Acl\UsersController@disable']);
    Route::get('users/search',                                  ['as' => 'users.searchlist',                'uses' => 'Admin\Acl\UsersController@searchList']);
    Route::get('roles/users/search',                            ['as' => 'users.search',                    'uses' => 'Admin\Acl\UsersController@searchByName']);
    Route::post('users/getInfo',                                ['as' => 'users.get-info',                  'uses' => 'Admin\Acl\UsersController@getInfo']);


//RoleController routes
    Route::get('roles',                                         ['as' => 'roles.index',                     'uses' => 'Admin\Acl\RolesController@index']);
    Route::get('roles/create',                                  ['as' => 'roles.create',                    'uses' => 'Admin\Acl\RolesController@create']);
    Route::post('roles/store',                                  ['as' => 'roles.store',                     'uses' => 'Admin\Acl\RolesController@store']);
    Route::get('roles/show/{roleId}',                           ['as' => 'roles.show',                      'uses' => 'Admin\Acl\RolesController@show']);
    Route::get('roles/{roleId}/edit',                           ['as' => 'roles.edit',                      'uses' => 'Admin\Acl\RolesController@edit']);
    Route::post('roles/{roleId}/update',                        ['as' => 'roles.update',                    'uses' => 'Admin\Acl\RolesController@update']);
    Route::post('roles/enableSelected',                         ['as' => 'roles.enable-selected',           'uses' => 'Admin\Acl\RolesController@enableSelected']);
    Route::post('roles/disableSelected',                        ['as' => 'roles.disable-selected',          'uses' => 'Admin\Acl\RolesController@disableSelected']);
    Route::get('roles/search',                                  ['as' => 'roles.search',                    'uses' => 'Admin\Acl\RolesController@searchByName']);
    Route::post('roles/getInfo',                                ['as' => 'roles.get-info',                  'uses' => 'Admin\Acl\RolesController@getInfo']);
    Route::get('roles/{roleId}/confirm-delete',                 ['as' => 'roles.confirm-delete',            'uses' => 'Admin\Acl\RolesController@getModalDelete']);
    Route::get('roles/{roleId}/delete',                         ['as' => 'roles.delete',                    'uses' => 'Admin\Acl\RolesController@destroy']);
    Route::get('roles/{roleId}/enable',                         ['as' => 'roles.enable',                    'uses' => 'Admin\Acl\RolesController@enable']);
    Route::get('roles/{roleId}/disable',                        ['as' => 'roles.disable',                   'uses' => 'Admin\Acl\RolesController@disable']);
//Route::resource('roles', 'Admin\Acl\RolesController');

//PermissionController routes
    Route::get('permissions',                                   ['as' => 'permissions.index',               'uses' => 'Admin\Acl\PermissionsController@index']);
    Route::get('permissions/create',                            ['as' => 'permissions.create',              'uses' => 'Admin\Acl\PermissionsController@create']);
    Route::post('permissions/store',                            ['as' => 'permissions.store',               'uses' => 'Admin\Acl\PermissionsController@store']);
    Route::get('permissions/show/{permissionId}',               ['as' => 'permissions.show',                'uses' => 'Admin\Acl\PermissionsController@show']);
    Route::get('permissions/{permissionId}/edit',               ['as' => 'permissions.edit',                'uses' => 'Admin\Acl\PermissionsController@edit']);
    Route::post('permissions/{permissionId}/update',            ['as' => 'permissions.update',              'uses' => 'Admin\Acl\PermissionsController@update']);
    Route::get('permissions/generate',                          ['as' => 'permissions.generate',            'uses' => 'Admin\Acl\PermissionsController@generate']);
    Route::get('permissions/reset',                             ['as' => 'permissions.reset',               'uses' => 'Admin\Acl\PermissionsController@reset']);
    Route::post('permissions/enableSelected',                   ['as' => 'permissions.enable-selected',     'uses' => 'Admin\Acl\PermissionsController@enableSelected']);
    Route::post('permissions/disableSelected',                  ['as' => 'permissions.disable-selected',    'uses' => 'Admin\Acl\PermissionsController@disableSelected']);
    Route::get('permissions/{permissionId}/confirm-delete',     ['as' => 'permissions.confirm-delete',      'uses' => 'Admin\Acl\PermissionsController@getModalDelete']);
    Route::get('permissions/{permissionId}/delete',             ['as' => 'permissions.delete',              'uses' => 'Admin\Acl\PermissionsController@destroy']);
    Route::get('permissions/{permissionId}/enable',             ['as' => 'permissions.enable',              'uses' => 'Admin\Acl\PermissionsController@enable']);
    Route::get('permissions/{permissionId}/disable',            ['as' => 'permissions.disable',             'uses' => 'Admin\Acl\PermissionsController@disable']);
//Route::resource('permissions', 'Admin\Acl\PermissionsController');

//RouteController routes
    Route::get('routes',                                        ['as' => 'routes.index',                    'uses' => 'Admin\Acl\RoutesController@index']);
    Route::get('routes/create',                                 ['as' => 'routes.create',                   'uses' => 'Admin\Acl\RoutesController@create']);
    Route::post('routes/store',                                 ['as' => 'routes.store',                    'uses' => 'Admin\Acl\RoutesController@store']);
    Route::get('routes/show/{routeId}',                         ['as' => 'routes.show',                     'uses' => 'Admin\Acl\RoutesController@show']);
    Route::get('routes/{routeId}/edit',                         ['as' => 'routes.edit',                     'uses' => 'Admin\Acl\RoutesController@edit']);
    Route::post('routes/{routeId}/update',                      ['as' => 'routes.update',                   'uses' => 'Admin\Acl\RoutesController@update']);
    Route::get('routes/load',                                   ['as' => 'routes.load',                     'uses' => 'Admin\Acl\RoutesController@load']);
    Route::get('routes/reset',                                  ['as' => 'routes.reset',                    'uses' => 'Admin\Acl\RoutesController@reset']);
//    Route::get('routes/refresh',                                ['as' => 'routes.refresh',                  'uses' => 'Admin\Acl\RoutesController@refresh']);
    Route::post('routes/enableSelected',                        ['as' => 'routes.enable-selected',          'uses' => 'Admin\Acl\RoutesController@enableSelected']);
    Route::post('routes/disableSelected',                       ['as' => 'routes.disable-selected',         'uses' => 'Admin\Acl\RoutesController@disableSelected']);
//Route::resource('routes', 'Admin\Acl\RoutesController');
    Route::get('routes/{routeId}/confirm-delete',               ['as' => 'routes.confirm-delete',           'uses' => 'Admin\Acl\RoutesController@getModalDelete']);
    Route::get('routes/{routeId}/delete',                       ['as' => 'routes.delete',                   'uses' => 'Admin\Acl\RoutesController@destroy']);
    Route::get('routes/{routeId}/enable',                       ['as' => 'routes.enable',                   'uses' => 'Admin\Acl\RoutesController@enable']);
    Route::get('routes/{routeId}/disable',                      ['as' => 'routes.disable',                  'uses' => 'Admin\Acl\RoutesController@disable']);
    Route::post('routes/savePerms',                             ['as' => 'routes.save-perms',               'uses' => 'Admin\Acl\RoutesController@savePerms']);
    Route::get('routes/search',                                 ['as' => 'routes.search',                   'uses' => 'Admin\Acl\RoutesController@searchByName']);
    Route::post('routes/getInfo',                               ['as' => 'routes.get-info',                 'uses' => 'Admin\Acl\RoutesController@getInfo']);
    /*****************End ACL*****************************/
});

?>