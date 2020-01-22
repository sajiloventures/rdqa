<?php

namespace App\Http\Controllers\Admin\Configuration;

use AppHelper;
use App\Http\Controllers\AdminBaseController;
use App\Models\Configuration;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends AdminBaseController
{



    /**
     * @var view location path
     */
    protected $view_path = 'admin.configuration.settings';

    /**
     * @var translation array path
     */
    protected $trans_path;

    public function __construct()
    {
        parent::__construct();

        $this->base_route = 'admin.configuration.settings';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);
    }

    public function index()
    {

        $data = Configuration::paginate(AppHelper::getConfigValue('ADMIN-PAGINATION-LIMIT'));

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));

    }

    public function basic(Request $request)
    {
        Validator::make($request->all(), [
            'option_name'    => 'required|unique:settings'
        ])->validate();

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

        Flash::success(trans($this->trans_path . 'general.status.created'));
        // 'Configuration successfully created');

        return $this->redirectToRoute();
    }
}
