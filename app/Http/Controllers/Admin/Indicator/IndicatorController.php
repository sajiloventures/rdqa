<?php

namespace App\Http\Controllers\Admin\Indicator;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Indicator\CreateIndicatorValidationRequest;
use App\Models\Indicator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth, Flash, AppHelper, AclHelper, DB;
use Yajra\Datatables\Datatables;

class IndicatorController extends AdminBaseController
{

    /**
     * @var view location path
     */
    protected $view_path = 'admin.indicator';
    protected $user_code = '';

    /**
     * @var translation array path
     */
    protected $trans_path;

    protected $user;
    protected $admin_user;

    public function __construct()
    {
        parent:: __construct();

        $this->base_route = 'admin.indicator';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
//        $this->importCSV();
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');
        $data['trans_path'] = $this->trans_path;
        $data['indicator-program'] = Indicator::select('program')->groupBy('program')->get();

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }


    public function search(Request $request)
    {
        $data = Indicator::select('*');
        $selectedIndicators = parent::getSelectedIndicatorsIds();
        return Datatables::of($data)
            ->editColumn('status', function ($indicator) use ($selectedIndicators) {
                return view($this->loadDefaultVars($this->view_path . '.partials._action_fields'), compact('indicator', 'selectedIndicators'))->render();

            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function importCSV()
    {

        $File = public_path('indicator_import.csv');
        $arrResult  = array();
        $handle     = fopen($File, "r");
        if(empty($handle) === false) {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                if (count($data) > 1) {
                    $eachRow = [
                        'program' => $data[0],
                        'name' => $data[1],
                        'code' => $data[2],
                        'user_id' => auth()->user()->id,
                        'status' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    $arrResult[] = $eachRow;
                }

            }
            fclose($handle);
        }
        Indicator::insert($arrResult);
        echo '<pre>';
        var_dump($arrResult);die;
    }

    public function create()
    {
        $data = [];
        $data['page_title'] =
            trans($this->trans_path . 'general.page.create.page-title');

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data', 'province'));
    }


    public function store(CreateIndicatorValidationRequest $request)
    {
        DB::beginTransaction();

        try {
            $indicator_detail = [
                'program'          => $request->get('program'),
                'name'          => $request->get('name'),
                'status'        => $request->has('status') ? 1 : 0,
            ];

            Indicator::create($indicator_detail);

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t create indicator.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('indicator-add-failed', $message);

            Flash::error(trans($this->trans_path . 'general.error.create'));
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.created'));
        return redirect()->route($this->base_route);

    }

    public function edit($id)
    {
        $indicator = Indicator::find($id);

        if(!$indicator) {
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->route($this->base_route);
        }

        return view($this->loadDefaultVars($this->view_path . '.edit'),
            compact('indicator'));
    }

    public function update(CreateIndicatorValidationRequest $request, $id)
    {
        $indicator = Indicator::find($id);


        if(!$indicator){
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-indicator'));
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $indicator->name  = $request->get('name');
            $indicator->program  = $request->get('program');
            if ($request->has('status'))
                $indicator->status = 1;
            else
                $indicator->status = 0;


            $indicator->save();

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t update indicator';
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('indicator-update-failed', $message);
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-indicator'));
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.updated'));
        return redirect()->route($this->base_route);
    }

    public function enable($id)
    {
        $indicator = Indicator::find($id);

        if (!$indicator) {
            Flash::error(trans($this->trans_path . 'general.error.enabled'));
            return redirect()->route($this->base_route);
        }
        $indicator->status = 1;
        $indicator->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'));

        return redirect(route($this->base_route));
    }

    public function enableDisableBulk(Request $request)
    {
        if ($request->get('program')) {
            if ($request->get('enable') == 1) {
                Indicator::where('program', $request->get('program'))->update(['status' => 0]);
                Flash::success('Indicators successfully disabled by program ' . $request->get('program'))->important();
            }
            if ($request->get('enable') == 0) {
                Indicator::where('program', $request->get('program'))->update(['status' => 1]);
                Flash::success('Indicators successfully enabled by program ' . $request->get('program'))->important();
            }
        } else {
            Flash::error(trans($this->trans_path . 'general.error.enabled'));
            return redirect()->route($this->base_route);
        }

        return redirect(route($this->base_route));
    }

    public function disable($id)
    {
        $indicator = Indicator::find($id);

        if (!$indicator) {
            Flash::error(trans($this->trans_path . 'general.error.disabled'));
            return redirect()->route($this->base_route);
        }
        $indicator->status = 0;
        $indicator->save();

        Flash::success(trans($this->trans_path . 'general.status.disabled'));

        return redirect(route($this->base_route));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $indicator = Indicator::find($id);
        try {
            if (!$indicator || in_array($indicator->id, parent::getSelectedIndicatorsIds())) {
                Flash::success(trans($this->trans_path . 'general.status.deleted'));
                return redirect()->route($this->base_route);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t remove indicator -> ' . $indicator ? $indicator->id : null;
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('indicator-delete-failed', $message);

        }

        DB::commit();

        if(!$indicator->delete())
            Flash::error(trans($this->trans_path . 'general.error.cant-delete-this-indicator'));
        else
            Flash::success(trans($this->trans_path . 'general.status.deleted'));

        return redirect()->route($this->base_route);

    }

}
