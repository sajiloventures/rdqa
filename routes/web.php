<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();


/*

User impersonate start from here
 */

Route::group(['middleware' => 'impersonate'], function () {


    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/logout', 'Auth\LoginController@logout')->name('admin.logout');
    /*
         * frontend
         * */
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/faq', 'FrontEndController@faq')->name('faq');
    Route::get('/manual', 'FrontEndController@userManual')->name('userManual');
    Route::get('/resources', 'FrontEndController@resources')->name('resources');
    Route::get('/download-manual', 'FrontEndController@downloadManual')->name('downloadManual');
    Route::get('/dropZone', 'Admin\Resource\UploadController@dropZone');
    Route::post('upload-advanced', 'Admin\Resource\UploadController@upload')->name('upload-advanced');
    Route::get('view-detail', ['as' => 'view-detail', 'uses' => 'Admin\DashboardController@index']);
    Route::get('get-facility', ['as' => 'get-facility',   'uses' => 'Admin\Instance\InstanceController@facilitySearch']);

    Route::post('request_access','Admin\Instance\InstanceController@mark_change');

    /**
     *admin section start
     **/
    /*acl admin users section*/
    Route::get('admin/error/{code}',                                                  ['as' => 'admin.error',                                   'uses' => 'Admin\DashboardController@error']);
    Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth', 'authorize']], function () {

        /*****************Start DASHBOARD*****************************/
        Route::get('', 'Admin\DashboardController@index')->name('dashboard');
        Route::get('dashboard',                                                     ['as' => 'home',                                    'uses' => 'Admin\DashboardController@index']);
        /*****************End DASHBOARD*****************************/

        /***************** Admin User **********************************/
        Route::get('admin_users',                                                   ['as' => 'admin_users',                             'uses' => 'Admin\Admin_Users\AdminUsersController@index']);
        Route::post('admin_users/search',                                           ['as' => 'admin_users.search',                      'uses' => 'Admin\Admin_Users\AdminUsersController@search']);
        Route::get('admin_users/create/',                                           ['as' => 'admin_users.create',                      'uses' => 'Admin\Admin_Users\AdminUsersController@create']);
        Route::post('admin_users/store',                                            ['as' => 'admin_users.store',                       'uses' => 'Admin\Admin_Users\AdminUsersController@store']);
        Route::get('admin_users/{userId}/edit',                                     ['as' => 'admin_users.edit',                        'uses' => 'Admin\Admin_Users\AdminUsersController@edit']);
        Route::post('admin_users/{userId}/update',                                  ['as' => 'admin_users.update',                      'uses' => 'Admin\Admin_Users\AdminUsersController@update']);
        Route::get('admin_users/{userId}/enable',                                   ['as' => 'admin_users.enable',                      'uses' => 'Admin\Admin_Users\AdminUsersController@enable']);
        Route::get('admin_users/{userId}/disable',                                  ['as' => 'admin_users.disable',                     'uses' => 'Admin\Admin_Users\AdminUsersController@disable']);
        Route::get('admin_users/{user_id}/delete',                                  ['as' => 'admin_users.delete',                      'uses' => 'Admin\Admin_Users\AdminUsersController@destroy']);
        Route::get('/admin_users/address',                                          ['as' => 'admin_users.address',                     'uses' => 'Admin\Admin_Users\AdminUsersController@nepalDetail']);
        Route::get('/admin_users/role',                                             ['as' => 'admin_users.roles',                       'uses' => 'Admin\Admin_Users\AdminUsersController@userDetails']);

        Route::get('/user/profile',                                                 ['as' => 'user.profile',                            'uses' => 'Admin\Admin_Users\AdminUsersController@editProfile']);
        Route::post('/user/profile',                                                ['as' => 'user.profile.update',                     'uses' => 'Admin\Admin_Users\AdminUsersController@updateProfile']);

        /***************** End: Admin User *****************************/

        /***************** Indicators **********************************/
        Route::get('indicator',                                                     ['as' => 'indicator',                               'uses' => 'Admin\Indicator\IndicatorController@index']);
        Route::post('indicator/search',                                             ['as' => 'indicator.search',                        'uses' => 'Admin\Indicator\IndicatorController@search']);
        Route::get('indicator/create/',                                             ['as' => 'indicator.create',                        'uses' => 'Admin\Indicator\IndicatorController@create']);
        Route::post('indicator/store',                                              ['as' => 'indicator.store',                         'uses' => 'Admin\Indicator\IndicatorController@store']);
        Route::get('indicator/{id}/edit',                                           ['as' => 'indicator.edit',                          'uses' => 'Admin\Indicator\IndicatorController@edit']);
        Route::post('indicator/{id}/update',                                        ['as' => 'indicator.update',                        'uses' => 'Admin\Indicator\IndicatorController@update']);
        Route::get('indicator/{id}/enable',                                         ['as' => 'indicator.enable',                        'uses' => 'Admin\Indicator\IndicatorController@enable']);
        Route::get('indicator/enable/all',                                          ['as' => 'indicator.enable_all',                    'uses' => 'Admin\Indicator\IndicatorController@enableDisableBulk']);
        Route::get('indicator/{id}/disable',                                        ['as' => 'indicator.disable',                       'uses' => 'Admin\Indicator\IndicatorController@disable']);
        Route::get('indicator/{id}/delete',                                         ['as' => 'indicator.delete',                        'uses' => 'Admin\Indicator\IndicatorController@destroy']);

        /***************** End: Indicators *****************************/

        /***************** Indicators **********************************/
        Route::get('compare_sheet',                                                 ['as' => 'compare_sheet',                           'uses' => 'Admin\CompareSheet\CompareSheetController@index']);
        Route::post('compare_sheet/search',                                         ['as' => 'compare_sheet.search',                    'uses' => 'Admin\CompareSheet\CompareSheetController@search']);
        Route::get('compare_sheet/create/',                                         ['as' => 'compare_sheet.create',                    'uses' => 'Admin\CompareSheet\CompareSheetController@create']);
        Route::post('compare_sheet/store',                                          ['as' => 'compare_sheet.store',                     'uses' => 'Admin\CompareSheet\CompareSheetController@store']);
        Route::get('compare_sheet/{id}/edit',                                       ['as' => 'compare_sheet.edit',                      'uses' => 'Admin\CompareSheet\CompareSheetController@edit']);
        Route::post('compare_sheet/{id}/update',                                    ['as' => 'compare_sheet.update',                    'uses' => 'Admin\CompareSheet\CompareSheetController@update']);
        Route::get('compare_sheet/{id}/enable',                                     ['as' => 'compare_sheet.enable',                    'uses' => 'Admin\CompareSheet\CompareSheetController@enable']);
        Route::get('compare_sheet/{id}/disable',                                    ['as' => 'compare_sheet.disable',                   'uses' => 'Admin\CompareSheet\CompareSheetController@disable']);
        Route::get('compare_sheet/{id}/delete',                                     ['as' => 'compare_sheet.delete',                    'uses' => 'Admin\CompareSheet\CompareSheetController@destroy']);

        /***************** End: Indicators *****************************/

        /***************** Facility **********************************/
        Route::get('facility',                                                      ['as' => 'facility',                                'uses' => 'Admin\Facility\FacilityController@index']);
        Route::post('facility/search',                                              ['as' => 'facility.search',                         'uses' => 'Admin\Facility\FacilityController@search']);
        Route::get('facility/create/',                                              ['as' => 'facility.create',                         'uses' => 'Admin\Facility\FacilityController@create']);
        Route::post('facility/store',                                               ['as' => 'facility.store',                          'uses' => 'Admin\Facility\FacilityController@store']);
        Route::get('facility/{id}/edit',                                            ['as' => 'facility.edit',                           'uses' => 'Admin\Facility\FacilityController@edit']);
        Route::post('facility/{id}/update',                                         ['as' => 'facility.update',                         'uses' => 'Admin\Facility\FacilityController@update']);
        Route::get('facility/{id}/enable',                                          ['as' => 'facility.enable',                         'uses' => 'Admin\Facility\FacilityController@enable']);
        Route::get('facility/{id}/disable',                                         ['as' => 'facility.disable',                        'uses' => 'Admin\Facility\FacilityController@disable']);
        Route::get('facility/{id}/delete',                                          ['as' => 'facility.delete',                         'uses' => 'Admin\Facility\FacilityController@destroy']);

        /***************** End: Facility *****************************/

        /***************** FAQ **********************************/
        Route::get('faq',                                                           ['as' => 'faq',                                     'uses' => 'Admin\FAQ\FAQController@index']);
        Route::post('faq/sort/',                                                    ['as' => 'faq.sortData',                            'uses' => 'Admin\FAQ\FAQController@sortData']);
        Route::get('faq/create/',                                                   ['as' => 'faq.create',                              'uses' => 'Admin\FAQ\FAQController@create']);
        Route::post('faq/store',                                                    ['as' => 'faq.store',                               'uses' => 'Admin\FAQ\FAQController@store']);
        Route::get('faq/{id}/edit',                                                 ['as' => 'faq.edit',                                'uses' => 'Admin\FAQ\FAQController@edit']);
        Route::post('faq/{id}/update',                                              ['as' => 'faq.update',                              'uses' => 'Admin\FAQ\FAQController@update']);
        Route::get('faq/{id}/enable',                                               ['as' => 'faq.enable',                              'uses' => 'Admin\FAQ\FAQController@enable']);
        Route::get('faq/{id}/disable',                                              ['as' => 'faq.disable',                             'uses' => 'Admin\FAQ\FAQController@disable']);
        Route::get('faq/{id}/delete',                                               ['as' => 'faq.delete',                              'uses' => 'Admin\FAQ\FAQController@destroy']);

        /***************** End: FAQ *****************************/

        /***************** Resource **********************************/
        Route::get('resource',                                                      ['as' => 'resource',                                'uses' => 'Admin\Resource\ResourceController@index']);
        Route::post('resource/search',                                              ['as' => 'resource.search',                         'uses' => 'Admin\Resource\ResourceController@search']);
        Route::get('resource/create/',                                              ['as' => 'resource.create',                         'uses' => 'Admin\Resource\ResourceController@create']);
        Route::post('resource/store',                                               ['as' => 'resource.store',                          'uses' => 'Admin\Resource\ResourceController@store']);
        Route::get('resource/{id}/edit',                                            ['as' => 'resource.edit',                           'uses' => 'Admin\Resource\ResourceController@edit']);
        Route::post('resource/{id}/update',                                         ['as' => 'resource.update',                         'uses' => 'Admin\Resource\ResourceController@update']);
        Route::get('resource/{id}/enable',                                          ['as' => 'resource.enable',                         'uses' => 'Admin\Resource\ResourceController@enable']);
        Route::get('resource/{id}/disable',                                         ['as' => 'resource.disable',                        'uses' => 'Admin\Resource\ResourceController@disable']);
        Route::get('resource/{id}/delete',                                          ['as' => 'resource.delete',                         'uses' => 'Admin\Resource\ResourceController@destroy']);
        Route::post('resource/upload',                                              ['as' => 'resource.upload',                         'uses' => 'Admin\Resource\UploadController@upload']);

        /***************** End: Resource *****************************/

        Route::get('user-manual',                                                   ['as' => 'userManual',                              'uses' => 'Admin\FAQ\FAQController@userManual']);
        Route::post('user-manual/store',                                            ['as' => 'userManual.store',                        'uses' => 'Admin\FAQ\FAQController@userManualStore']);

        /***************** Questions **********************************/
        Route::get('question',                                                      ['as' => 'question',                                'uses' => 'Admin\Question\QuestionController@index']);
        Route::post('question/edit_title',                                          ['as' => 'question.getEditModal',                   'uses' => 'Admin\Question\QuestionController@getTitleEditModal']);
        Route::post('question/update_title',                                        ['as' => 'question.updateTitle',                    'uses' => 'Admin\Question\QuestionController@updateTitle']);
        Route::post('question/add',                                                 ['as' => 'question.getAddQuestionModal',            'uses' => 'Admin\Question\QuestionController@getAddQuestionModal']);
        Route::post('question/update',                                              ['as' => 'question.addUpdateQuestions',             'uses' => 'Admin\Question\QuestionController@addUpdateQuestions']);

        /***************** End: Questions *****************************/

        /***************** Instance **********************************/
        Route::get('instance',                                                      ['as' => 'instance',                                'uses' => 'Admin\Instance\InstanceController@index']);
        Route::post('instance/search',                                              ['as' => 'instance.search',                         'uses' => 'Admin\Instance\InstanceController@search']);
        Route::get('instance/create',                                               ['as' => 'instance.create',                         'uses' => 'Admin\Instance\InstanceController@create']);
        Route::get('instance/indicator',                                            ['as' => 'instance.indicator',                      'uses' => 'Admin\Instance\InstanceController@indicatorSearch']);
        Route::get('instance/facility',                                             ['as' => 'instance.facility',                       'uses' => 'Admin\Instance\InstanceController@facilitySearch']);
        Route::post('instance/store',                                               ['as' => 'instance.store',                          'uses' => 'Admin\Instance\InstanceController@store']);

        Route::get('instance/{id}/edit',                                            ['as' => 'instance.edit',                           'uses' => 'Admin\Instance\InstanceController@edit']);
        Route::post('instance/{id}/update',                                         ['as' => 'instance.update',                         'uses' => 'Admin\Instance\InstanceController@update']);
        Route::get('instance/{id}/delete',                                          ['as' => 'instance.destroy',                        'uses' => 'Admin\Instance\InstanceController@destroy']);

        // view graphs and details of an instance
        Route::get('instance/delivery_site/view/{instance_id?}',                     ['as' => 'instance.deliverySite.view',              'uses' => 'Admin\Instance\InstanceController@view_detail']);

        // add edit different question sections data
        Route::get('instance/delivery_site/{instance_id}',                          ['as' => 'instance.deliverySite',                   'uses' => 'Admin\Instance\InstanceController@siteDeliveryPartOne']);
        Route::post('instance/delivery_site/{instance_id}/one',                     ['as' => 'instance.deliverySite.partOne.store',     'uses' => 'Admin\Instance\InstanceController@saveSiteDeliveryPartOneData']);
        Route::post('instance/delivery_site/{instance_id}/two',                     ['as' => 'instance.deliverySite.partTwo.store',     'uses' => 'Admin\Instance\InstanceController@saveSiteDeliveryPartTwoData']);
        Route::post('instance/delivery_site/{instance_id}/three',                   ['as' => 'instance.deliverySite.partThree.store',   'uses' => 'Admin\Instance\InstanceController@saveSiteDeliveryPartThreeData']);

        /***************** End: Instance *****************************/

        /*****************User Impersonation*****************************/
        Route::get('/users/{id}/impersonate',                   ['as' => 'users.impersonate',       'uses' => 'AdminBaseController@impersonate']);
        /*****************Stop Impersonation*****************************/

        /*****************Start Configuration*****************************/
        Route::get('/settings',                                 ['as' => 'settings',                'uses' => 'Admin\Configuration\SettingsController@index']);
        Route::post('settings/basic',                           ['as' => 'settings.basic',          'uses' => 'Admin\Configuration\SettingsController@basic']);
        Route::post('settings/smtp',                            ['as' => 'settings.smtp',           'uses' => 'Admin\Configuration\SettingsController@basic']);
        Route::post('settings/social',                          ['as' => 'settings.social',         'uses' => 'Admin\Configuration\SettingsController@social']);
        /*****************End CONFIGURATION*****************************/

        /*****************Start ACL*****************************/
        require base_path('routes/modules/acl.php');
        /*****************End ACL*****************************/

        // Refresh or migrate database content with cache clear and other basic tasks
        Route::get('migrate',                          ['as' => 'migrate',         'uses' => 'Admin\DashboardController@refreshContent']);

    });

    /*******************************************************************
     * User Impersonation logout
     * Kept outside authorize for universal role
     *******************************************************************/
    Route::get('admin/users/stop',                              ['as' => 'admin.users.stop',        'uses' => 'AdminBaseController@stopImpersonate']);

});
