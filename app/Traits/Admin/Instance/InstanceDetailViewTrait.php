<?php
namespace App\Traits\Admin\Instance;

use App\Classes\AppHelper;
use App\Models\CompareSheet;
use App\Models\Instance;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\SiteDeliveryData;
use App\Models\SiteDeliverySystemAssessment;
use Illuminate\Http\Request;
use DB, Flash;

trait InstanceDetailViewTrait {

    public function view_detail($id = null)
    {
        $idsByRole = parent::getInstancesIdsByRole();

        if ($id && !in_array($id, $idsByRole))
        {
            Flash::error(trans($this->trans_path . 'general.error.invalid'))->important();
            return redirect()->route($this->base_route);
        }

        $returnDataOnly = false;

        $data['search_request'] = false;
        $data['display_search'] = true;

        $data['search_province'] = $this->facilitySearch(request());

        if (!$id) {
            $instances = Instance::select('instance.*')
                ->leftJoin('instance_site_delivery as isd', 'instance.id', '=', 'isd.instance_id')
                ->where('instance.built_stage', 'step-4')
                ->whereIn('instance.id', $idsByRole);

            // Function to built instance query for search request
            $request = $_REQUEST;
//            dd($request);
            list($instances, $data['search_request'], $data['from_date'], $data['to_date']) = $this->searchRequestQueryBuilder($instances, $request);

            // get one month data only
            if (!$data['search_request']){
                $currentMonth = (int) date('m');
                $fiscalMonth = (int) \AppHelper::getConfigValue('DEFAULT_FISCAL_MONTH');
                if ($currentMonth > $fiscalMonth)
                    $fiscalYear = (int) date('Y');
                else
                    $fiscalYear = (int) date('Y') - 1;

                $data['to_date'] = date('Y-m-d', strtotime($fiscalYear . '-' . $fiscalMonth . '-15'));
                $data['from_date'] = date('Y-m-d', strtotime(($fiscalYear - 1) . '-' . $fiscalMonth . '-15'));
                $instances->whereBetween('instance.created_at', [$data['from_date'], $data['to_date']]);

            }
            $instances = $instances->get();

        } else {
            $data['display_search'] = false;
            $instances = Instance::whereIn('id', $idsByRole)
                ->where('id', $id)
                ->get();
            if ($instances[0]->built_stage != 'step-4')
                $returnDataOnly = true;
        }


        $data['system_assessment_data'] = Question::select('id', 'type_name')
            ->where('part', 'part-2')
            ->orderBy('sort_order')
            ->ByStatus()
            ->get();

        $data['instances'] = $instances;
        if (count($instances) > 0) {

            $data['selected-indicators'] = [];
            $data['action-plan-question'] = Question::where('part', 'part-3')->get();

            $selectedInstancesIds = [];
            $selectedInstancesName = [];
            $data['system-assessment-list'] = [];
            foreach ($instances as $instance) {
                foreach ($instance->indicators as $indicator) {
                    $data['selected-indicators'] += [
                        $indicator->indicator_id => [
                            'id' => $indicator->indicator_id,
                            'name' => $indicator->indicator->name,
                            'program' => $indicator->indicator->program
                        ]
                    ];
                }
                array_push($selectedInstancesIds, $instance->id);
                array_push($selectedInstancesName, $instance->name);
                $data['system-assessment-list'] += [
                    $instance->id => [
                        'name' => $instance->name,
                        'assessment' => $this->getSystemAssessmentByInstances($instance)
                    ]
                ];
            }
            $data += $this->getGraphData($selectedInstancesIds);

            if ($id) {
                $data += ['projects-name' => $selectedInstancesName];
                $data['instance'] = $instances->first();
                $data['instanceSystemAssessment'] = $data['instance'] ? $data['instance']
                    ->siteDeliverySystemAssessment()
                    ->with('siteQuestion')
                    ->orderBy('question_id')
                    ->get() : [];
            }

            if ($returnDataOnly)
                return $data;
        } else {
            if ($data['search_request'])
                Flash::error('Data not found.');
        }

//        $data['compare_sheet'] = CompareSheet::select('id')
//            ->selectRaw('CONCAT(name, " vs ", name_2) as com_name')
//            ->ByStatus()
//            ->get()
//            ->pluck('com_name', 'id')
//            ->toArray();

        $data['page_layout'] = 'frontend';
        if (auth()->check())
            $data['page_layout'] = 'admin';

        return view($this->loadDefaultVars($this->view_path . '.graph_view'), compact('data'));
    }

    private function searchRequestQueryBuilder($instance, $request)
    {
        $searchText = null;
        $from_date = $to_date = null;
        if (isset($request['from_date']) && $request['from_date']) {
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $searchText = 'Date = ' . $from_date . ' to ' . $to_date;
            $instance->whereBetween('instance.created_at', [$from_date, $to_date]);
//            dd([$from_date, $to_date]);
        }


        if (isset($request['province_name']) && $request['province_name']) {
            $instance->where('isd.province_name', $request['province_name']);
            $searchText .= ' <br /> Province="' . $request['province_name'] .'"';
        }

        if (isset($request['district_name']) && $request['district_name']) {
            $instance->where('isd.district_name', $request['district_name']);
            $searchText .= ' <br /> District="' . $request['district_name'] .'"';
        }

        if (isset($request['palika_name']) && $request['palika_name']) {
            $instance->where('isd.palika_name', $request['palika_name']);
            $searchText .= ' <br /> Palika="' . $request['palika_name'] .'"';
        }

        if (isset($request['hf_name']) && $request['hf_name']) {
            $instance->where('isd.facility_name', $request['hf_name']);
            $searchText .= ' <br /> Facility="' . $request['hf_name'] .'"';
        }

        return [$instance, $searchText, $from_date, $to_date];
    }

    public function getGraphData($id = [])
    {
        if (!is_array($id) || count($id) < 1)
            return [
                'system-assessment' => [],
                'reporting-performance' => [],
                'cross-check-1' => [],
                'cross-check-2' => [],
                'cross-check-3' => [],
            ];

        $data['system-assessment'] = SiteDeliverySystemAssessment::select('site_delivery_system_assessment.question_id', 'q.part', 'q.part_name as title', 'q.type_name as name')
            ->selectRaw('SUM(site_delivery_system_assessment.value) as total')
            ->selectRaw('COUNT(site_delivery_system_assessment.id) as number')
            ->leftJoin('questions as q', 'q.id', 'site_delivery_system_assessment.question_id')
            ->whereIn('site_delivery_system_assessment.instance_id', $id)
            ->where('q.part', 'part-2')
            ->groupBy('site_delivery_system_assessment.question_id')
            ->get();

        $data['reporting-performance'] = SiteDeliveryData::select('site_delivery_data.*', 'q.part', 'q.part_name as title', 'q.type_name as name')
            ->leftJoin('questions as q', 'q.id', 'site_delivery_data.question_id')
            ->whereIn('site_delivery_data.instance_id', $id)
            ->where('q.part', 'part-1')
            ->where('q.type', 'b')
            ->groupBy('site_delivery_data.indicator_id')
            ->get();

        $data['cross-check-1'] = SiteDeliveryData::select('site_delivery_data.*', 'q.part', 'q.part_name as title', 'q.type_name as name')
            ->leftJoin('questions as q', 'q.id', 'site_delivery_data.question_id')
            ->whereIn('site_delivery_data.instance_id', $id)
            ->where('q.part', 'part-1')
            ->where('q.type', 'c')
            ->where('q.sub_type', 'cross-check-1')
            ->groupBy('site_delivery_data.indicator_id')
            ->get();

        $data['cross-check-2'] = SiteDeliveryData::select('site_delivery_data.*', 'q.part', 'q.part_name as title', 'q.type_name as name')
            ->leftJoin('questions as q', 'q.id', 'site_delivery_data.question_id')
            ->whereIn('site_delivery_data.instance_id', $id)
            ->where('q.part', 'part-1')
            ->where('q.type', 'c')
            ->where('q.sub_type', 'cross-check-2')
            ->groupBy('site_delivery_data.indicator_id')
            ->get();

        $data['cross-check-3'] = $this->getCrossCheck3Data($id);

        return $data;
    }

    public function getCrossCheck3Data($id = [])
    {

        $data = SiteDeliveryData::select('site_delivery_data.*', 'q.part', 'q.part_name as title', 'q.type_name as name')
            ->selectRaw('SUM(site_delivery_data.value) as value_1_total')
            ->selectRaw('SUM(site_delivery_data.value_2) as value_2_total')
            ->selectRaw('MAX(site_delivery_data.id) as max_id')
            ->leftJoin('questions as q', 'q.id', 'site_delivery_data.question_id')
            ->whereIn('site_delivery_data.instance_id', $id)
            ->where('q.part', 'part-1')
            ->where('q.type', 'c')
            ->where('q.sub_type', 'cross-check-3')
            ->groupBy('site_delivery_data.indicator_id')
            ->get();

        $maxIds = [];
        foreach ($data as $row)
            array_push($maxIds, $row->max_id);

        $getDataWithMaxIds = SiteDeliveryData::select('id', 'value', 'value_2')
            ->whereIn('id', $maxIds)
            ->whereIn('instance_id', $id)
            ->get();

        $array = [];
        foreach ($getDataWithMaxIds as $dt)
            $array += [
                $dt->id => $dt
            ];

        $finalData = [];

        foreach ($data as $row) {
            if (isset($array[$row->max_id])) {
                $row->value = $array[$row->max_id]->value;
                $row->value_2 = $array[$row->max_id]->value_2;
            }
            array_push($finalData, $row);
        }

        return $finalData;

    }

    public function getSystemAssessmentByInstances($instance = null)
    {
        $systemAssessments = [];
        if ($instance && $instance->siteDeliverySystemAssessment)
        {
            $systemAssessments = $instance->siteDeliverySystemAssessment()
                ->select('*')
                ->selectRaw('SUM(value) as total')
                ->selectRaw('COUNT(id) as number')
                ->selectRaw('GROUP_CONCAT(remarks separator ", ") as all_remarks')
                ->groupBy('question_id')
                ->get();
        }

        return $systemAssessments;
    }
}