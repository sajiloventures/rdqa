<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\InstanceIndicators;
use App\Models\InstanceSiteDelivery;
use App\User;
use Illuminate\Support\Facades\Auth;
use Regulus\ActivityLog\Models\Activity;
use View;
use AppHelper;

class AdminBaseController extends AppBaseController
{

    /**
     * External packages must set to false
     *
     * @var bool
     */
    protected $app_model = true;

    public function __construct()
    {
        /*
         * !! Not to remove !!
         */
        parent::__construct();
    }

    /**
     * Delete confirmation for list pages
     *
     * @param $pk
     * @return View
     */
    protected function getModalDelete($pk)
    {
        $error = null;

        $model = $this->model;
        $data = $model::ByActiveLang()->pk($pk)->first();

        $modal_title = trans($this->trans_path . 'dialog.delete-confirm.title');
        $modal_cancel = trans('general.button.cancel');
        $modal_ok = trans('general.button.ok');
        $modal_name = isset($data->name) ? $data->name : $data->title;
        $modal_route = route($this->base_route . '.delete', array('id' => $data->primary_key));

        $modal_body = trans($this->trans_path . 'dialog.delete-confirm.body', ['id' => $data->primary_key, 'name' => $modal_name]);

        return view('modal_confirmation', compact('error', 'modal_route',
            'modal_title', 'modal_body', 'modal_cancel', 'modal_ok'));

    }

    /**
     * Assign variables to passed view and
     * return passed view path
     *
     * @param $view_path View to which value is to be assigned
     * @param array $params
     * @return mixed
     */
    protected function loadDefaultVars($view_path, $params = [])
    {
        try {

            View::composer($view_path, function ($view) use ($view_path, $params) {

                //$transPath = AppHelper::getTransPathFromViewPath($view_path, true);
                $file_name = AppHelper::getFileNameFormViewPath($view_path);

                //  Make Translation Path from passed View Path
                $view->with('trans_path', $this->trans_path);
                $view->with('admin_trans_path', 'admin/');

                // Make View Path available to view
                $view->with('view_path', AppHelper::getBasePathFromViewPath($view_path, true));
                // Make route prefix available
                $view->with('base_route', $this->base_route);

                // Image path
                $view->with('image_path', $this->imagePath);

                // Site Configuartion array
                $view->with('infos', $this->site_infos);
                // user impersonate
                if (Auth::check())
                    $view->with('impersonate', Auth::user()->isImpersonating());

                // Page Title
                $view->with('page_title', trans($this->trans_path . 'general.page.' . $file_name . '.title'));
                // Page Description
                $view->with('page_description', trans($this->trans_path . 'general.page.' . $file_name . '.description'));



            });

            return $view_path;

        } catch (\Exception $e) {
            AppHelper::exceptionHandler($e);
        }
    }


    /** User Impersonation (view accounts)
     * @param Request $request
     * @return mixed
     */
    public function impersonate($id)
    {
        $user = User::find($id);

        // Guard against administrator impersonate
        if(!$user->isAdministrator())
        {
            Auth::user()->setImpersonating($user->id);

            Activity::log([
                'contentId'   => $user->id,
                'contentType' => 'Impersonation',
                'action'      => 'Create',
                'description' => 'Admin User login to: '.$user->email,
                'details'     => url()->current(),
                'updated'     => (bool) Auth::user()->id,
            ]);

        }
        else
        {
            flash()->error('Impersonate disabled for this user.');
        }

        return redirect('/admin/dashboard');
    }

    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        flash()->success('Welcome back! Admin');

//        return redirect()->back();
        return redirect('/admin/dashboard');
    }



    /**
     * Gets used facility users ids
     * This method helps to check user been used or not before delete.
     * @return array
     */

    public function getSelectedFacilityUserIds()
    {
      //  $facilityUsers = InstanceSiteDelivery::select('facility_user_id')->groupBy('facility_user_id')->get();
        $usersIds = [];
    /*    foreach ($facilityUsers as $facilityUser) {
            if (!in_array($facilityUser->facility_user_id, $usersIds))
                array_push($usersIds, $facilityUser->facility_user_id);
        }

        $palikaUsers = AdminUser::whereIn('id', $usersIds)->get();
        foreach ($palikaUsers as $users) {
            if (!in_array($users->palika_user_id, $usersIds))
                array_push($usersIds, $users->palika_user_id);

            if (!in_array($users->created_by, $usersIds))
                array_push($usersIds, $users->created_by);
        }*/

        return $usersIds;
    }
    /**
     * Gets used indicators ids
     * This method helps to check indicator been used or not before delete.
     * @return array
     */

    public function getSelectedIndicatorsIds()
    {
        $indicators = InstanceIndicators::select('indicator_id')->groupBy('indicator_id')->get();
        $indicatorIds = [];
        foreach ($indicators as $indicator)
            array_push($indicatorIds, $indicator->indicator_id);

        return $indicatorIds;
    }
    /**
     * Gets used facilities ids
     * This method helps to check facility been used or not before delete.
     * @return array
     */

    public function getSelectedFacilityIds()
    {
        $facilities = InstanceSiteDelivery::select('facility_id')->groupBy('facility_id')->get();
        $facilityIds = [];
        foreach ($facilities as $facility)
            array_push($facilityIds, $facility->facility_id);

        return $facilityIds;
    }


}
