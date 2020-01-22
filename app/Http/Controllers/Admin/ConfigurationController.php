<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigurationController extends AdminBaseController
{


    /**
     * @var view location path
     */
    protected $view_path = 'admin.configuration';

    /**
     * @var translation array path
     */
    protected $trans_path;

    public function __construct()
    {
        parent::__construct();

        $this->base_route = 'admin.configuration';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);
    }

    public function index()
    {
        $data['page_title'] = trans($this->trans_path.'general.content.list');
        $data['add_btn_html'] = view($this->loadDefaultVars($this->view_path. '.partials._configuration_add_button'), compact('data'))->render();

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));


//        $data = Configuration::paginate(AppHelper::getConfigValue('ADMIN-PAGINATION-LIMIT'));
//
//        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }

    public function search(Request $request)
    {
        $configure = Configuration::select('id', 'option_name', 'option_value', 'remarks', 'status');
        return Datatables::of($configure->get())
            ->editColumn('id', function ($configure) {
                $data = view($this->loadDefaultVars($this->view_path . '.partials._action_fields'), compact('configure'))->render();
                return $data;
            })
            ->editColumn('status', function ($configure) {
                if ($configure->status === 1) {
                    return "<span class='text-success'> " .
                        '<i class="fa fa-check-circle-o text-info"></i>' .
                        "</span>";
                }
                return "<span class='text-danger'>  " .
                    '<i class="fa fa-ban text-danger"></i>' .
                    "</span>";
            })
            ->make(true);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['add_btn_html'] = view($this->loadDefaultVars($this->view_path. '.partials._add_form_button'), compact('data'))->render();
        $data['page_title'] = trans($this->trans_path.'general.page.create.description');
        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data'));
    }

    public function store(CreateConfigurationValidationRequest $request)
    {
        if (isset($request->status) || $request->status != null){
            $status = 1;
        } else {
            $status = 0;
        }
        // For Root user only
        Configuration::create([
            'option_name' => $request->option_name,
            'option_value' => $request->option_value,
            'remarks' => $request->remarks,
            'status' => $status
        ])->save();

        Flash::success(trans($this->trans_path . 'general.status.created')); // 'Configuration successfully created');

        return $this->redirectToRoute();
    }

    public function edit($id)
    {
        $configure = Configuration::find($id);
        $data['add_btn_html'] = view($this->loadDefaultVars($this->view_path. '.partials._add_form_button'))->render();
        $data['page_title'] = trans($this->trans_path.'general.page.edit.description');

        return view($this->loadDefaultVars($this->view_path . '.edit'), compact('configure', 'data'));
    }

    public function update(EditConfigurationValidationRequest $request, $id)
    {

        if (isset($request->status) || $request->status != null){
            $status = 1;
        } else {
            $status = 0;
        }
        $config = Configuration::find($id);

        $getConfigData = [
            'option_value'  =>  $request->option_value,
            'remarks'       =>  $request->remarks,
            'status'        =>  $status
        ];

        //check for user and provide access level
        if($config->isEditableBy())
            $config->update(array_merge($getConfigData, ['option_name' => $request->option_name]));
        else{
            //for normal user
            $config->update($getConfigData);
        }

        Flash::success( trans($this->trans_path . 'general.status.updated') );

        return $this->redirectToRoute($id);
    }

    public function delete($id)
    {

        // Remove for Root only
        $config = Configuration::find($id);

        if(!$config->isDeletableBy()){
            Flash::error(trans($this->trans_path . 'general.status.invalid'));
            return $this->redirectToRoute($this->base_route);
        }

        if($config->delete($id)){
            Flash::success( trans($this->trans_path . 'general.status.deleted') );
            return redirect()->route($this->base_route);
        }

        Flash::success( trans($this->trans_path . 'general.status.deleted') );
        return redirect()->route($this->base_route);
    }

    public function destroy(Request $request)
    {
        $retVal = 'error';

        if (isset($request->bulk) && $request->bulk == 'bulk') {

            foreach ($request->id as $id) {

                $config = Configuration::find($id);

                if($config->isDeletableBy()) {
                    if($config->delete()) {
                        $retVal =  'ok';
                    } else {
                        $retVal = 'error';
                    }
                }
            }

        } else {

            $config = Configuration::find($request->id);

            if($config->isDeletableBy()) {
                if($config->delete()) {
                    $retVal =  'ok';
                } else {
                    $retVal = 'error';
                }
            }

        }

        return $retVal;
    }

    public function getModalDelete($id)
    {
        $error = null;

        $config = Configuration::find($id);

        $modal_title = trans($this->trans_path . 'dialog.delete-confirm.title');
        $modal_cancel = trans('general.button.cancel');
        $modal_ok = trans('general.button.ok');


        $modal_route = route($this->base_route.'.delete', array('id' => $config->id));

        $modal_body = trans($this->trans_path. 'dialog.delete-confirm.body', ['id' => $config->id, 'name' => $config->option_name]);

        return view('admin.modal_confirmation', compact('error', 'modal_route',
            'modal_title', 'modal_body', 'modal_cancel', 'modal_ok'));

    }

    public function enable($id, $req_type = null)
    {
        $config = Configuration::find($id);
        $config->status = 1;
        $config->save();

        if ($req_type = 'bulk') {
            return 'ok';
        } else {
            return 'error';
        }
    }

    public function disable($id)
    {
        $config = Configuration::find($id);

        $config->status = 0;
        $config->save();

        if ($req_type = 'bulk') {
            return 'ok';
        } else {
            return 'error';
        }
    }

    public function enableAll(Request $request){
        foreach ($request->id as $id){
            $retVal = $this->enable($id, 'bulk');
        }
        return $retVal;
    }

    public function disableAll(Request $request){
        foreach ($request->id as $id){
            $retVal = $this->disable($id, 'bulk');
        }
        return $retVal;
    }

}
