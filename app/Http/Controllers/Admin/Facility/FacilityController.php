<?php

namespace App\Http\Controllers\Admin\Facility;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Facility\CreateFacilityValidationRequest;
use App\Models\Facility;
use App\Models\ProvinceDistrict;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth, Flash, AppHelper, AclHelper, DB;
use Yajra\Datatables\Datatables;

class FacilityController extends AdminBaseController
{

    /**
     * @var view location path
     */
    protected $view_path = 'admin.facility';
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

        $this->base_route = 'admin.facility';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
//        $this->importCSV();
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');
        $data['trans_path'] = $this->trans_path;
//        $data['facility'] = Facility::ByStatus()->get();

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }


    public function search(Request $request)
    {
        $data = Facility::select('*');

        $selectedFacilityIds = parent::getSelectedFacilityIds();

        return Datatables::of($data)
            ->editColumn('status', function ($facility) use ($selectedFacilityIds) {
                return view($this->loadDefaultVars($this->view_path . '.partials._action_fields'), compact('facility', 'selectedFacilityIds'))->render();

            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function importCSV()
    {

        $File = public_path('facility_csv/facility_1.csv');
//        $File = public_path('facility_csv/facility_2.csv');
        $arrResult  = array();
        $handle     = fopen($File, "r");
        if(empty($handle) === false) {
            $user_id = auth()->user()->id;
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                if (count($data) > 1) {

                    $eachRow = [
                        'user_id' => $user_id,
                        'province_code'     => $data[0],
                        'province_name'     => $data[1],
                        'district_code'     => $data[2],
                        'district_name'     => $data[3],
                        'palika_code'       => $data[4],
                        'palika_name'       => $data[5],
                        'ward_code'         => $data[6],
                        'ward_name'         => $data[7],
                        'hf_id'             => $data[8],
                        'hf_code'           => $data[9],
                        'hf_name'           => $data[10],
                        'hf_type'           => $data[11],
                        'ownership_type'    => $data[12],
                        'urban_rural'       => $data[13],
                        'geography'         => $data[14],
                        'public_nonpublic'  => $data[15],
                        'status' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];


                    $arrResult[] = $eachRow;
                }

            }
            fclose($handle);
        }
//        dd($arrResult);
        Facility::insert($arrResult);
        echo '<pre>';
        var_dump($arrResult);die;
    }

    public function create()
    {
        $data = [];
        $data['page_title'] =
            trans($this->trans_path . 'general.page.create.page-title');

        $province = $this->getProvince();

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data', 'province'));
    }

    private function getProvince()
    {
        $province = [];
        $getProvince = ProvinceDistrict::select('state')->groupBy('state')->orderBy('state')->get();
        foreach ($getProvince as $prov)
            $province += ['Province ' . $prov->state => 'Province ' . $prov->state];
        return $province;
    }


    public function store(CreateFacilityValidationRequest $request)
    {
        DB::beginTransaction();

        try {
            $facility_detail = [
                'user_id' => auth()->user()->id,
                'province_code' => $request->get('province_code'),
                'province_name' => $request->get('province_name'),
                'district_code' => $request->get('district_code'),
                'district_name' => $request->get('district_name'),
                'palika_code' => $request->get('palika_code'),
                'palika_name' => $request->get('palika_name'),
                'ward_code' => $request->get('ward_code'),
                'ward_name' => $request->get('ward_name'),
                'hf_code' => $request->get('hf_code'),
                'hf_name' => $request->get('hf_name'),
                'hf_type' => $request->get('hf_type'),
                'ownership_type' => $request->get('ownership_type'),
                'urban_rural' => $request->get('urban_rural'),
                'geography' => $request->get('geography'),
                'public_nonpublic' => $request->get('public_nonpublic'),
                'status'        => $request->has('status') ? 1 : 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            Facility::create($facility_detail);

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t create facility.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('facility-add-failed', $message);

            Flash::error(trans($this->trans_path . 'general.error.create'));
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.created'));
        return redirect()->route($this->base_route);

    }

    public function edit($id)
    {
        $facility = Facility::find($id);

        $province = $this->getProvince();

        if(!$facility) {
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->route($this->base_route);
        }

        return view($this->loadDefaultVars($this->view_path . '.edit'),
            compact('facility', 'province'));
    }

    public function update(CreateFacilityValidationRequest $request, $id)
    {
        $facility = Facility::find($id);


        if(!$facility){
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-facility'));
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $facility->province_code    = $request->get('province_code');
            $facility->province_name    = $request->get('province_name');
            $facility->district_code    = $request->get('district_code');
            $facility->district_name    = $request->get('district_name');
            $facility->palika_code      = $request->get('palika_code');
            $facility->palika_name      = $request->get('palika_name');
            $facility->ward_code        = $request->get('ward_code');
            $facility->ward_name        = $request->get('ward_name');
            $facility->hf_code          = $request->get('hf_code');
            $facility->hf_name          = $request->get('hf_name');
            $facility->hf_type          = $request->get('hf_type');
            $facility->ownership_type   = $request->get('ownership_type');
            $facility->urban_rural      = $request->get('urban_rural');
            $facility->geography        = $request->get('geography');
            $facility->public_nonpublic = $request->get('public_nonpublic');
            $facility->updated_at       = Carbon::now();

            if ($request->has('status'))
                $facility->status = 1;
            else
                $facility->status = 0;


            $facility->save();

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t update facility';
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('facility-update-failed', $message);
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-facility'));
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.updated'));
        return redirect()->route($this->base_route);
    }

    public function enable($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            Flash::error(trans($this->trans_path . 'general.error.enabled'));
            return redirect()->route($this->base_route);
        }
        $facility->status = 1;
        $facility->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'));

        return redirect(route($this->base_route));
    }

    public function disable($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            Flash::error(trans($this->trans_path . 'general.error.disabled'));
            return redirect()->route($this->base_route);
        }
        $facility->status = 0;
        $facility->save();

        Flash::success(trans($this->trans_path . 'general.status.disabled'));

        return redirect(route($this->base_route));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $facility = Facility::find($id);
        try {
            if (!$facility || in_array($facility->id, parent::getSelectedFacilityIds())) {
                Flash::success(trans($this->trans_path . 'general.status.deleted'));
                return redirect()->route($this->base_route);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t remove facility -> ' . $facility ? $facility->id : null;
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('facility-delete-failed', $message);

        }

        DB::commit();

        if(!$facility->delete())
            Flash::error(trans($this->trans_path . 'general.error.cant-delete-this-facility'));
        else
            Flash::success(trans($this->trans_path . 'general.status.deleted'));

        return redirect()->route($this->base_route);

    }
}
