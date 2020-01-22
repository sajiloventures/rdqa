<?php

namespace App\Http\Controllers\Admin\Instance;

use App\Http\Controllers\Admin\Question\QuestionBaseController;
use App\Http\Controllers\AdminBaseController;
use App\Models\AdminUser;
use App\Models\CompareSheet;
use App\Models\Facility;
use App\Models\Indicator;
use App\Models\Instance;
use App\Models\InstanceIndicatorCrossCheck;
use App\Models\InstanceIndicators;
use App\Models\InstanceSiteDelivery;
use App\Models\Question;
use App\Models\SiteDeliveryData;
use App\Models\SiteDeliveryFollowUp;
use App\Models\SiteDeliveryQuestions;
use App\Models\SiteDeliverySystemAssessment;
use App\Traits\Admin\Instance\InstanceDetailViewTrait;
use App\Traits\Admin\Instance\InstanceSiteDeliveryTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth, Flash, AppHelper, AclHelper, DB;
use Yajra\Datatables\Datatables;

class InstanceController extends QuestionBaseController
{
    use InstanceSiteDeliveryTrait, InstanceDetailViewTrait;

    /**
     * @var view location path
     */
    protected $view_path = 'admin.instance';
    protected $user_code = '';

    /**
     * @var translation array path
     */
    protected $trans_path;
    public $instance;

    public function __construct()
    {
        parent:: __construct();

        $this->base_route = 'admin.instance';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');
        $data['trans_path'] = $this->trans_path;
        $data['instances'] = Instance::select('instance.*')
            ->selectRaw('GROUP_CONCAT(CONCAT(ind.name, " (<strong>", ii.from_date, "~", ii.to_date, "</strong>)") SEPARATOR ",<br />") as indicators')
            ->leftJoin('instance_indicators as ii', 'instance.id', '=', 'ii.instance_id')
            ->leftJoin('indicator as ind', 'ii.indicator_id', '=', 'ind.id')
            ->whereIn('instance.id', parent::getInstancesIdsByRole())
            ->groupBy('instance.id')
            ->get();

        $data['questions'] = Question::select('part', 'part_name')->groupBy(['part', 'part_name'])->get();

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }


    public function search(Request $request)
    {
        $data = Instance::select('instance.*')
            ->selectRaw('GROUP_CONCAT(CONCAT(ind.name, " (<strong>", ii.from_date, "~", ii.to_date, "</strong>)") SEPARATOR ",<br />") as indicators')
            ->leftJoin('instance_indicators as ii', 'instance.id', '=', 'ii.instance_id')
            ->leftJoin('indicator as ind', 'ii.indicator_id', '=', 'ind.id')
            ->whereIn('instance.id', parent::getInstancesIdsByRole())
            ->groupBy('instance.id');

        return Datatables::of($data)
            ->editColumn('built_stage', function ($instance) {
                return AppHelper::getBuildStage($instance->built_stage);

            })
            ->addColumn('facility_name', function ($instance) {
                return $instance->siteDelivery ? $instance->siteDelivery->facility_name : null;

            })
            ->editColumn('created_at', function ($instance) {
                return date('Y-m-d', strtotime($instance->created_at));

            })
            ->addColumn('user', function ($instance) {
                return ($instance->siteDelivery && $instance->siteDelivery->user) ? ($instance->siteDelivery->user->first_name . ' ' . $instance->siteDelivery->user->last_name) : null;

            })
            ->addColumn('status', function ($instance) {
                return view($this->loadDefaultVars($this->view_path . '.partials._action_fields'), compact('instance'))->render();

            })
            ->filterColumn('indicators', function($query, $keyword) {
                $sql = 'ind.name like ?';
//                $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
                $sql = 'ii.from_date like ?';
                $query->orWhereRaw($sql, ["%{$keyword}%"]);
                $sql = 'ii.to_date like ?';
                $query->orWhereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['status', 'built_stage', 'created_at', 'user', 'indicators'])
            ->make(true);
    }

    public function create()
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.create.page-title');

        $data += $this->getPreviousInstanceWithOtherRequiredData();

        $province = $this->facilitySearch(request());
       // dd($province);

        $data['compareSheets'] = CompareSheet::all();
        $data['enable_hf_change'] = 'yes';
        $data['enable_dd_change'] = 'yes';
        $data['enable_pr_change'] = 'yes';
        $data['enable_pa_change'] = 'yes';
        $data['enable_hf_change'] = 'yes';

        $data['user'] = auth()->user();
        if (\AclHelper::getUserRole() === 'province-user') {
        $data['enable_pr_change'] = 'no';
        }
        else if (\AclHelper::getUserRole() === 'district-user') {
        $data['enable_pa_change'] = 'yes';
        $data['enable_dd_change'] = 'no';
            $data['enable_pr_change'] = 'no';
        $data['enable_hf_change'] = 'yes';
        } else if (\AclHelper::getUserRole() === 'facility-user') {
        $data['enable_pa_change'] = 'no';
        $data['enable_dd_change'] = 'no';
            $data['enable_pr_change'] = 'no';
            $data['enable_hf_change'] = 'no';
        } else if (\AclHelper::getUserRole() === 'palika-user') {
        $data['enable_pa_change'] = 'no';
        $data['enable_dd_change'] = 'no';
        $data['enable_pr_change'] = 'no';
        $data['enable_hf_change'] = 'yes';
        }
        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data', 'province'));

    }

    /**
     * Get previous instance for action plan update
     * returns previous instance with correct roles
     * and also returns part-3 question format when required
     *
     * @param null $instance_id
     * @param bool $requireOtherData
     * @return mixed
     */

    private function getPreviousInstanceWithOtherRequiredData($instance_id = null, $requireOtherData = true)
    {
        if (\AclHelper::getUserRole() == 'facility-user')
            $data['facility_users'] = [auth()->user()];
        else if (\AclHelper::getUserRole() == 'palika-user')
            $data['facility_users'] = AdminUser::ByStatus()->where('palika_user_id', auth()->user()->id)->get();
        else if (\AclHelper::getUserRole() == 'district-user')
            $data['facility_users'] = AdminUser::ByStatus()->where('district_user_id', auth()->user()->id)->get();
        else
            $data['facility_users'] = AdminUser::ByStatus()->where('palika_user_id', '>', 0)->get();


        $facilityUsersIds = [];

        foreach ($data['facility_users'] as $fu)
            array_push($facilityUsersIds, $fu->id);

        $data['previous_instance'] = Instance::select('instance.*')
            ->leftJoin('instance_site_delivery as sd', 'instance.id', '=', 'sd.instance_id')
            ->whereIn('sd.facility_user_id', $facilityUsersIds);

        if ($instance_id)
            $data['previous_instance']->where('instance.id', '<', $instance_id);

        $data['previous_instance'] = $data['previous_instance']->orderBy('instance.id', 'desc')->first();

        if ($requireOtherData)
            $data['questions'] = Question::select('id', 'part', 'part_name', 'type', 'type_name')
                ->where('part', 'part-3')
                ->get();

        $data['indicator-programs'] = Indicator::select('program')->groupBy('program')->get();

        return $data;
    }

    public function indicatorSearch(Request $request)
    {
        $indicators = Indicator::select('id', 'program', 'name')
            ->ByStatus();

        if ($request->get('program'))
            $indicators = $indicators->where('program', $request->get('program'));

        $indicators = $indicators->where('name', 'like', '%' . $request->get('search') . '%')
            ->get();

        $data['items'] = [];
        foreach ($indicators as $indicator) {
            array_push($data['items'], [
                'id' => $indicator->id,
                'program' => $indicator->program,
                'name' => $indicator->name,
            ]);
        }
        return response()->json($data);
    }

//    public function facilitySearch(Request $request)
//    {
//
//        $facilities = Facility::select('id', 'name')
//            ->ByStatus()
//            ->where('name', 'like', '%' . $request->get('search') . '%')
//            ->get();
//
//        $data['items'] = [];
//        foreach ($facilities as $facility) {
//            array_push($data['items'], [
//                'id' => $facility->id,
//                'name' => $facility->name,
//            ]);
//        }
//        return response()->json($data);
//    }

    public function facilitySearch(Request $request)
    {
        $data = [];
        $type = $id = null;
        if ($request->has('type'))
            $type = $request->get('type');

        if ($request->has('id'))
            $id = $request->get('id');

        switch ($type) {

            case 'district_name':
                $district = Facility::select('district_name')->ByStatus()->where('province_name', $id)->groupBy('district_name')->orderBy('district_name')->get();

                foreach ($district as $row)
                    array_push($data, $row->district_name);

                $data = response()->json($data);

                break;
            case 'palika_name':
                $palika_name = Facility::select('palika_name')->ByStatus()->where('district_name', $id)->groupBy('palika_name')->orderBy('palika_name')->get();

                foreach ($palika_name as $row)
                    array_push($data, $row->palika_name);

                $data = response()->json($data);
                break;
            case 'health_post_name':
                $hf_name = Facility::select('id', 'hf_name')->ByStatus()->where('palika_name', $id)->groupBy('hf_name')->orderBy('hf_name')->get();

                foreach ($hf_name as $row)
                    $data += [$row->id => $row->hf_name];

                $data = response()->json($data);
                break;
            default:
                $province = Facility::select('province_name')->groupBy('province_name')->orderBy('province_name')->get();
               // dd($province);
                foreach ($province as $prov)
                    $data += [$prov->province_name => $prov->province_name];
                break;
        }
        //dd($data);
        return $data;

    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            $evaluationTeam = [];
            if ($request->has('team-name')) {
                $count = 0;
                foreach ($request->get('team-name') as $team) {
                    array_push($evaluationTeam, [
                        'name' => $request->get('team-name')[$count],
                        'title' => $request->get('team-title')[$count],
                        'organization' => $request->get('team-organization')[$count],
                        'email' => $request->get('team-email')[$count],
                        'telephone' => $request->get('team-telephone')[$count]
                    ]);
                    $count++;
                }
            }

            $instanceArray = [
                'name' => $request->get('name'),
                'created_by' => auth()->user()->id,
                'built_stage' => 'step-1',
                'evaluation_team' => serialize($evaluationTeam),
            ];

            $facility = Facility::ByStatus()->find($request->get('hf_name'));
            if (!$facility) {
                Flash::error('Selected health facility is invalid.')->important();
                return redirect()->back();
            }

            $instance = Instance::create($instanceArray);

            $instanceSiteDelivery = InstanceSiteDelivery::create([
                'facility_user_id' => auth()->user()->id,
                'created_by' => auth()->user()->id,
                'instance_id' => $instance->id,
                'facility_id' => $facility->id,
                'facility_name' => $facility->hf_name,
                'facility_code' => $facility->hf_code,
                'province_name' => $facility->province_name,
                'district_name' => $facility->district_name,
                'palika_name' => $facility->palika_name,
            ]);

            $selectedIndicatorCrossCheck = [];
            if ($request->has('indicator')) {
                $count = 0;
                foreach ($request->get('indicator') as $indicator) {
                    $instanceIndicator = InstanceIndicators::create([
                        'instance_id' => $instance->id,
                        'indicator_id' => $request->get('indicator')[$count],
                        'from_date' => date('Y-m-d', strtotime($request->get('from_date')[$count])),
                        'to_date' => date('Y-m-d', strtotime($request->get('to_date')[$count])),
                        'from_date_eng' => date('Y-m-d', strtotime($request->get('from_date_eng')[$count])),
                        'to_date_eng' => date('Y-m-d', strtotime($request->get('to_date_eng')[$count])),
                    ]);

                    array_push($selectedIndicatorCrossCheck, [
                        'instance_id' => $instance->id,
                        'instance_indicator_id' => $instanceIndicator->id,
                        'cross_check_1_a_id' => $request->get('cross_check_1_a')[$count],
                        'cross_check_2_a_id' => $request->get('cross_check_2_a')[$count],
                        'cross_check_3_a_id' => $request->get('cross_check_3_a')[$count],
                    ]);
                    $count++;
                }
            }

            InstanceIndicatorCrossCheck::insert($selectedIndicatorCrossCheck);


            $data = $this->getPreviousInstanceWithOtherRequiredData($instance->id, false);

            if ($data['previous_instance'] && count($data['previous_instance']->siteFollowUp) > 0) {
                $data['previous_instance']->siteFollowUp()->update(['completed' => 0]);

                if ($request->get('plan_id') && is_array($request->get('plan_id')))
                    $data['previous_instance']->siteFollowUp()->whereIn('id', $request->get('plan_id'))->update(['completed' => 1]);

            }


        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t add instance details.';
            $message .= PHP_EOL . 'Error: ' . $e->getMessage();
            $message .= PHP_EOL . 'Path: ' . get_class($this) . '@' . __FUNCTION__;
            $message .= PHP_EOL . 'Line: ' . $e->getLine();
            $message .= PHP_EOL . 'URl: ' . request()->fullUrl();
            \AppHelper::systemError('user-add-failed', $message);

            Flash::error(trans($this->trans_path . 'general.error.create'))->important();
            return redirect()->route($this->base_route);
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.created'))->important();
        $redirectTo = route($this->base_route . '.deliverySite', $instance->id) . '?entry_type=part-1&redirectTo=part-1';
        return redirect($redirectTo);
    }


    public function edit($id)
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.edit.page-title');
        $data['instance'] = Instance::where('built_stage', '!=', 'step-4')->whereIn('id', parent::getInstancesIdsByRole())->find($id);
        if ($data['instance']) {

            $data['indicators'] = Indicator::select('ii.*', 'indicator.program', 'indicator.name', 'iicc.*')
                ->leftJoin('instance_indicators as ii', 'ii.indicator_id', '=', 'indicator.id')
                ->leftJoin('instance_indicator_cross_check as iicc', 'iicc.instance_indicator_id', '=', 'ii.id')
                ->where('ii.instance_id', $data['instance']->id)
                ->orderBy('ii.id')
                ->get();

            $data += $this->getPreviousInstanceWithOtherRequiredData($id);

            $data['compareSheets'] = CompareSheet::all();
            $data['compareSheetsArray'] = $this->createCompareSheetArray($data['compareSheets']);
//            dd($data['compareSheetsArray']);
            $data['evaluationTeam'] = $data['instance']->evaluation_team ? unserialize($data['instance']->evaluation_team) : [];

            $province = $this->facilitySearch(request());


            $data['enable_hf_change'] = 'yes';
            $data['enable_pr_change'] = 'yes';
            
            $data['user'] = auth()->user();
            if (\AclHelper::getUserRole() === 'facility-user') {
                $data['enable_hf_change'] = 'no';
                $data['enable_pr_change'] = 'no';
            } else if (\AclHelper::getUserRole() === 'palika-user') {
                $data['enable_hf_change'] = 'hf';
                $data['enable_pr_change'] = 'no';

            }

            return view($this->loadDefaultVars($this->view_path . '.edit'), compact('data', 'province'));
        }

        Flash::error(trans($this->trans_path . 'general.error.invalid'))->important();
        return redirect()->route($this->base_route);
    }

    public function update(Request $request, $id)
    {
        $instance = Instance::where('built_stage', '!=', 'step-4')->whereIn('id', parent::getInstancesIdsByRole())->find($id);

        if (!$instance) {
            Flash::error(trans($this->trans_path . 'general.error.invalid'))->important();
            return redirect()->route($this->base_route);
        }

        $data = $this->getPreviousInstanceWithOtherRequiredData($id, false);

        if ($data['previous_instance'] && count($data['previous_instance']->siteFollowUp) > 0) {
            $data['previous_instance']->siteFollowUp()->update(['completed' => 0]);

            if ($request->get('plan_id') && is_array($request->get('plan_id')))
                $data['previous_instance']->siteFollowUp()->whereIn('id', $request->get('plan_id'))->update(['completed' => 1]);

        }


        DB::beginTransaction();

        try {

            $evaluationTeam = [];
            if ($request->has('team-name')) {
                $count = 0;
                foreach ($request->get('team-name') as $team) {
                    array_push($evaluationTeam, [
                        'name' => $request->get('team-name')[$count],
                        'title' => $request->get('team-title')[$count],
                        'organization' => $request->get('team-organization')[$count],
                        'email' => $request->get('team-email')[$count],
                        'telephone' => $request->get('team-telephone')[$count]
                    ]);
                    $count++;
                }
            }

            $instanceArray = [
                'name' => $request->get('name'),
                'created_by' => auth()->user()->id,
                'built_stage' => 'step-1',
                'evaluation_team' => serialize($evaluationTeam),
            ];

            $facility = Facility::ByStatus()->find($request->get('hf_name'));

            if (!$facility) {
                Flash::error('Selected health facility is invalid.')->important();
                return redirect()->back();
            }

            $instance->update($instanceArray);

            $instanceSiteDeliveryDetail = [
                'facility_user_id' => auth()->user()->id,
                'facility_id' => $facility->id,
                'facility_name' => $facility->hf_name,
                'facility_code' => $facility->hf_code,
                'province_name' => $facility->province_name,
                'district_name' => $facility->district_name,
                'palika_name' => $facility->palika_name,
            ];
            $instanceSiteDelivery = $instance->siteDelivery;
            if ($instanceSiteDelivery) {
                $instanceSiteDelivery->update($instanceSiteDeliveryDetail);
            } else {
                $instanceSiteDeliveryDetail += [
                    'created_by' => auth()->user()->id,
                    'instance_id' => $instance->id
                ];
                $instanceSiteDelivery = InstanceSiteDelivery::create($instanceSiteDeliveryDetail);
            }

            $selectedIndicatorIds = [];
            $selectedInstanceIndicatorIds = [];
            if ($request->has('indicator')) {
                $count = 0;
                foreach ($request->get('indicator') as $indicator) {
                    $instanceIndicator = InstanceIndicators::updateOrCreate([
                        'instance_id' => $instance->id,
                        'indicator_id' => $request->get('indicator')[$count],
                    ], [
                        'from_date' => date('Y-m-d', strtotime($request->get('from_date')[$count])),
                        'to_date' => date('Y-m-d', strtotime($request->get('to_date')[$count])),
                        'from_date_eng' => date('Y-m-d', strtotime($request->get('from_date_eng')[$count])),
                        'to_date_eng' => date('Y-m-d', strtotime($request->get('to_date_eng')[$count])),
                    ]);

                    $instanceIndicatorCrossCheck = InstanceIndicatorCrossCheck::updateOrCreate([
                        'instance_id' => $instance->id,
                        'instance_indicator_id' => $instanceIndicator->id,
                    ], [
                        'cross_check_1_a_id' => $request->get('cross_check_1_a')[$count],
                        'cross_check_2_a_id' => $request->get('cross_check_2_a')[$count],
                        'cross_check_3_a_id' => $request->get('cross_check_3_a')[$count],
                    ]);

                    array_push($selectedIndicatorIds, $instanceIndicator->indicator_id);
                    array_push($selectedInstanceIndicatorIds, $instanceIndicatorCrossCheck->id);
                    $count++;
                }
            }

            // Deletes data with not selected indicators.
            InstanceIndicators::where('instance_id', $instance->id)
                ->whereNotIn('indicator_id', $selectedIndicatorIds)
                ->delete();

            InstanceIndicatorCrossCheck::where('instance_id', $instance->id)
                ->whereNotIn('id', $selectedInstanceIndicatorIds)
                ->delete();

            SiteDeliveryData::where('instance_id', $instance->id)
                ->whereNotIn('indicator_id', $selectedIndicatorIds)
                ->delete();


        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t update instance details.';
            $message .= PHP_EOL . 'Error: ' . $e->getMessage();
            $message .= PHP_EOL . 'Path: ' . get_class($this) . '@' . __FUNCTION__;
            $message .= PHP_EOL . 'Line: ' . $e->getLine();
            $message .= PHP_EOL . 'URl: ' . request()->fullUrl();
            \AppHelper::systemError('instance-update-failed', $message);

            Flash::error(trans($this->trans_path . 'general.error.update'))->important();
            return redirect()->route($this->base_route);
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.updated'))->important();
        $redirectTo = route($this->base_route . '.deliverySite', $instance->id) . '?entry_type=part-1&redirectTo=part-1';

        return redirect($redirectTo);
    }

    private function createCompareSheetArray($compareSheet)
    {
        $array = [];
        foreach ($compareSheet as $sheet)
            $array += [
                $sheet->id => $sheet->name . ' vs ' . $sheet->name_2
            ];

        return $array;
    }

    public function destroy($instance_id)
    {
        $instance = Instance::whereIn('id', parent::getInstancesIdsByRole())
            ->where('id', $instance_id)
            ->first();
        if (!$instance) {
            Flash::error(trans($this->trans_path . 'general.error.delete'))->important();
            return redirect()->route($this->base_route);
        }

        DB::beginTransaction();

        try {
            InstanceIndicators::where('instance_id', $instance->id)->delete();
            InstanceIndicatorCrossCheck::where('instance_id', $instance->id)->delete();
            InstanceSiteDelivery::where('instance_id', $instance->id)->delete();
            SiteDeliveryData::where('instance_id', $instance->id)->delete();
            SiteDeliveryFollowUp::where('instance_id', $instance->id)->delete();
            SiteDeliveryQuestions::where('instance_id', $instance->id)->delete();
            SiteDeliverySystemAssessment::where('instance_id', $instance->id)->delete();
            $instance->delete();

            DB::commit();

            Flash::success(trans($this->trans_path . 'general.status.delete'))->important();
            return redirect()->route($this->base_route);

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t delete instance.';
            $message .= PHP_EOL . 'Error: ' . $e->getMessage();
            $message .= PHP_EOL . 'Path: ' . get_class($this) . '@' . __FUNCTION__;
            $message .= PHP_EOL . 'Line: ' . $e->getLine();
            $message .= PHP_EOL . 'URl: ' . request()->fullUrl();
            \AppHelper::systemError('user-delete-failed', $message);

        }

        Flash::error(trans($this->trans_path . 'general.error.delete'))->important();
        return redirect()->route($this->base_route);

    }


}
