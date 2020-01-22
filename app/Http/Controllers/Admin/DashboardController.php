<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Instance\InstanceController;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\AppBaseController;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AppHelper,Auth,AclHelper, DB;

class DashboardController extends AdminBaseController
{
    /**
     * @var view location path
     */
    protected $view_path = 'admin.dashboard';

    /**
     * @var translation array path
     */
    protected $trans_path;

    protected $error_codes;

    public function __construct()
    {
        parent:: __construct();

        $this->base_route = 'admin.dashboard';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

        $this->error_codes = config('rdqa.error-codes');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        returns graph view from instance
        $instance = new InstanceController();
        return $instance->view_detail();

//        $user = Auth::user();
//        $dependencies = AppBaseController::dependencies();
//        $environments = AppBaseController::Environment();
//        $data['page_title'] = trans($this->trans_path . 'page.list');
//        return view($this->loadDefaultVars($this->view_path.'.home'), compact('user','data','dependencies','environments'));
    }

    /**
     * Loads admin error pages
     *
     * @param Request $request
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function error(Request $request, $code = null)
    {
        if (in_array($code, $this->error_codes)) {
            $trans_path = 'admin/error.';
            $text = [];
            $text['code'] = trans($trans_path.'not-found.code');
            $text['title'] = trans($trans_path.'not-found.title');
            $text['description'] = trans($trans_path.'not-found.description');
            $text['back_to_text'] = trans($trans_path.'not-found.back_to_text');
            $text['back_to_link'] = route('home');

            switch ($code) {

                case 'no-error-code-passed':

                    $text['code'] = trans($trans_path.'no-error-code-passed.code');
                    $text['title'] = trans($trans_path.'no-error-code-passed.title');
                    $text['description'] = trans($trans_path.'no-error-code-passed.description');

                    break;

                case 'system-error':

                    $text['code'] = trans($trans_path.'system-error.code');
                    $text['title'] = trans($trans_path.'system-error.title');
                    $text['description'] = trans($trans_path.'system-error.description');

                    break;

                case 'invalid-request':

                    $text['code'] = trans($trans_path.'invalid-request.code');
                    $text['title'] = trans($trans_path.'invalid-request.title');
                    $text['description'] = trans($trans_path.'invalid-request.description');

                    break;

                case 'un-authorized-request':

                    $text['code'] = '401';
                    $text['title'] = trans($trans_path.'un-authorized-request.title');
                    $text['description'] = trans($trans_path.'un-authorized-request.description');

                    break;

                case 'event-not-found':

                    $text['title'] = trans($trans_path.'event-not-found.title');
                    $text['description'] = trans($trans_path.'event-not-found.description');

                    break;

            }

            return view($this->loadDefaultVars('layouts.error', [
                'show_dev_admin_menu' => in_array(AclHelper::getUsersTypeKey('dev-admin'), AclHelper::getUserRoles(), 1),
                'show_org_admin_menu' => in_array(AclHelper::getUsersTypeKey('org-admin'), AclHelper::getUserRoles(), 1),
                'show_emp_user_menu' => in_array(AclHelper::getUsersTypeKey('emp-user'), AclHelper::getUserRoles(), 1)
            ]), compact('text'));

        }
        else
            return redirect()->route('admin.error', [
                'code' => AppHelper::getErrorCode('invalid-request')
            ]);
    }

    public function refreshContent()
    {
        \Artisan::call('migrate');
        \Artisan::call('view:clear');
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        $addRolePrefix = '';
        if ($numberOfRolesUpdated = $this->addRolesIfNotExist())
            $addRolePrefix = $numberOfRolesUpdated . ' roles added and ';
        \Flash::success($addRolePrefix . 'Migration with cache clear successfully done.')->important();
        return redirect()->route('admin.home');
    }

    private function addRolesIfNotExist()
    {
        $configRoles = config('rdqa.admin-users-roles');
        $roles = Role::select('name')->pluck('name')->toArray();
        $position = count($roles);
        $count = 0;

        DB::beginTransaction();

        try {
            foreach ($configRoles as $key => $config) {
                if (!in_array($key, $roles)) {
                    $role = new Role();
                    $role->name = $config['key'];
                    $role->display_name = $config['title'];
                    $role->description = $config['title'];
                    $role->enabled = 1;
                    $role->position = ++$position;
                    $role->created_at = \Carbon\Carbon::now();
                    $role->updated_at = \Carbon\Carbon::now();
                    $role->save();
                    $count++;

                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Couldn\'t update user roles.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('user-role-update-failed', $message);

        }

        DB::commit();
        return $count;

    }


}
