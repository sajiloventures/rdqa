<?php
namespace App\Traits\Admin\Instance;

use App\Http\Controllers\Admin\Question\QuestionBaseController;
use App\Models\Indicator;
use App\Models\Instance;
use App\Models\Question;
use App\Models\SiteDeliveryData;
use App\Models\SiteDeliveryFollowUp;
use App\Models\SiteDeliveryQuestions;
use App\Models\SiteDeliverySystemAssessment;
use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use DB, Flash;

trait InstanceSiteDeliveryTrait {
    public $selectedCrossCheckIds = [];
    public $siteDelivery;
    public $questionArray =[];
    public $siteDeliveryQuestionUpdateIdsArray =[];
    public $siteDeliveryDataUpdateIdsArray =[];

    public function siteDeliveryPartOne(Request $request, $id)
    {
        if ($request->get('entry_type') && $questions = Question::where('part', $request->get('entry_type'))->get()) {
            $data['questions'] = parent::createQuestionArray($questions);
            $data['instance'] = $this->instance = Instance::FilterByStage()
                ->whereIn('id', parent::getInstancesIdsByRole())
                ->where('id', $id)
                ->first();

            $data += $this->getRedirectPath($request, $id);

            if ($data['instance']) {

                switch ($request->get('entry_type')) {
                    case 'part-1':
                        $data['indicators'] = Indicator::select('ii.*', 'indicator.name', 'iicc.*')
                            ->leftJoin('instance_indicators as ii', 'ii.indicator_id', '=', 'indicator.id')
                            ->leftJoin('instance_indicator_cross_check as iicc', 'iicc.instance_indicator_id', '=', 'ii.id')
                            ->where('ii.instance_id', $data['instance']->id)
                            ->orderBy('ii.id')
                            ->get();
                        foreach ($data['indicators'] as $indicator) {
                            $this->checkAndPushInArray($indicator->cross_check_1_a_id);
                            $this->checkAndPushInArray($indicator->cross_check_1_b_id);
                            $this->checkAndPushInArray($indicator->cross_check_2_a_id);
                            $this->checkAndPushInArray($indicator->cross_check_2_b_id);
                            $this->checkAndPushInArray($indicator->cross_check_3_a_id);
                            $this->checkAndPushInArray($indicator->cross_check_3_b_id);
                        }

                        $data['cross_checks'] = parent::getCompareSheetArray($this->selectedCrossCheckIds);

                        $this->questionArray = $data['questions']['part-1'];

                        $data['questions']['part-1'] = $this->assignStoredDataToAnArray('part-1');
                        return view($this->loadDefaultVars($this->view_path . '.part-1'), compact('data'));
                        break;
                    case 'part-2':
                        $this->questionArray = $data['questions']['part-2'];
                        $data['questions']['part-2'] = $this->assignStoredDataToAnArray('part-2');
                        return view($this->loadDefaultVars($this->view_path . '.part-2'), compact('data'));
                        break;
                    case 'part-3':
                        $this->questionArray = $data['questions']['part-3'];
                        $data['actionPlans'] = SiteDeliveryFollowUp::where('instance_id', $this->instance->id)
                            ->where('site_delivery_id', $this->instance->siteDelivery->id)
                            ->get();

                        $graphData = null;
                        if ($this->instance->id)
                            $graphData = $this->view_detail($this->instance->id);

                        if ($graphData && is_array($graphData))
                            $data += $graphData;
                        return view($this->loadDefaultVars($this->view_path . '.part-3'), compact('data'));
                        break;
                }
            }
        }
        Flash::error(trans($this->trans_path . 'general.error.not-valid-part'))->important();
        return redirect()->route($this->base_route);

    }

    public function getRedirectPath($request, $id)
    {
        $redirectPath = [
            'redirectTo' => null,
            'redirectPath' => route($this->base_route)
        ];

        if ($request->get('redirectTo')) {
            if ($request->get('redirectTo') == 'part-1') {
                $redirectPath['redirectPath'] = route($this->base_route . '.deliverySite', $id) . '?entry_type=part-1&redirectTo=part-2';
                $redirectPath['redirectTo'] = 'part-2';
            }
            if ($request->get('redirectTo') == 'part-2') {
                $redirectPath['redirectPath'] = route($this->base_route . '.deliverySite', $id) . '?entry_type=part-2&redirectTo=part-2';
                $redirectPath['redirectTo'] = 'part-3';
            }
            if ($request->get('redirectTo') == 'part-3')
                $redirectPath['redirectPath'] = route($this->base_route . '.deliverySite', $id) . '?entry_type=part-3';
        }

        return $redirectPath;
    }

    private function getStoredData($part = null)
    {
        $this->siteDelivery =  $this->instance->siteDelivery;
        return $this->siteDelivery->siteQuestions()->where('part', $part)->get();
    }

    private function assignStoredDataToAnArray($part = null)
    {
        foreach ($this->getStoredData($part) as $data) {
            if (isset($this->questionArray['type'][$data->type])) {
                if (!isset($this->questionArray['type'][$data->type]['data']))
                    $this->questionArray['type'][$data->type] += ['data' => []];

                if ($data->sub_type) {

                    if (!isset($this->questionArray['type'][$data->type]['type'][$data->sub_type]['data']))
                        $this->questionArray['type'][$data->type]['type'][$data->sub_type] += ['data' => []];

                    $this->questionArray['type'][$data->type]['type'][$data->sub_type]['data'] += [$data->question_list_id => $this->getDataByIndicator($data, $part)];
                } else {
                    $this->questionArray['type'][$data->type]['data'] += [$data->question_list_id => $this->getDataByIndicator($data, $part)];
                }
            }
        }

        return $this->questionArray;

    }

    private function getDataByIndicator($siteDeliveryQuestion = null, $part = null)
    {
        $resultArray = [];
        if ($siteDeliveryQuestion && $part)
        {
            if ($part == 'part-1') {
                foreach ($siteDeliveryQuestion->siteData as $data) {
                    $resultArray += [
                        $data->indicator_id => $data
                    ];
                }
            } else  if ($part == 'part-2') {
                return $siteDeliveryQuestion->siteAssessment;
            }
        }
        return $resultArray;
    }


    // todo: remove this
    private function recursiveFunction($array = [], $selectedType = null)
    {
        if (isset($array['type']) && count($array['type']) > 0)
        {
            foreach ($array['type'] as $key => $type) {
                $array['type'][$key] += $this->recursiveFunction($type, $key);
            }
        } else {
            foreach ($this->getStoredData() as $data)
            {
                if ($data->type == $selectedType || $data->sub_type == $selectedType)
                {
                    $array = ['added_' . $selectedType  => $selectedType];
                }
            }
        }

        return $array;

    }

    public function checkAndPushInArray($value)
    {
        if (!in_array($value, $this->selectedCrossCheckIds))
            array_push($this->selectedCrossCheckIds, $value);

        return $this->selectedCrossCheckIds;
    }

    public function saveSiteDeliveryPartOneData(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $instance = Instance::FilterByStage()
                ->whereIn('instance.id', parent::getInstancesIdsByRole())
                ->where('id', $id)
                ->first();

            $redirectArray = $this->getRedirectPath($request, $id);

            if ($instance && $request->get('part-1') && isset($request->get('part-1')['type'])) {
                $partType = $request->get('part-1')['type'];
                $serviceSiteDelivery = $instance->siteDelivery;

                // store type data
                $this->storeTypeAData($partType, $instance, $serviceSiteDelivery, $request);
                $this->storeTypeBData($partType, $instance, $serviceSiteDelivery, $request);
                $this->storeTypeCData($partType, $instance, $serviceSiteDelivery, $request);

                SiteDeliveryData::where('instance_id', $instance->id)
                    ->whereIn('site_delivery_questions_id', $this->siteDeliveryQuestionUpdateIdsArray)
                    ->whereNotIn('id', $this->siteDeliveryDataUpdateIdsArray)
                    ->delete();

                SiteDeliveryQuestions::where('instance_id', $instance->id)
                    ->where('part', 'part-1')
                    ->whereNotIn('id', $this->siteDeliveryQuestionUpdateIdsArray)
                    ->delete();

                if ($instance->built_stage == 'step-1') {
                    $instance->built_stage = 'step-2';
                    $instance->save();
                }
                DB::commit();

                Flash::success(trans($this->trans_path . 'general.status.part-1'));
                return redirect($redirectArray['redirectPath']);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t add part-1 data.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'Line: '.$e->getLine();
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('siteDeliveryData-add-failed', $message);
        }


        Flash::error(trans($this->trans_path . 'general.error.part-1'));
        return redirect()->route($this->base_route);

    }

    public function storeTypeAData($partType, $instance, $serviceSiteDelivery, $request)
    {
        if (isset($partType['a'])) {
            foreach ($partType['a'] as $questionId => $indicatorsArray) {
                if (count($indicatorsArray) > 0) {
                    $siteDeliveryQuestion = null;
                    foreach ($indicatorsArray as $indicatorValue) {
                        $siteDeliveryData = null;
                        if (isset($indicatorValue['site_delivery_id']) && $indicatorValue['site_delivery_id'])
                        {
                            $siteDeliveryData = SiteDeliveryData::find($indicatorValue['site_delivery_id']);

                            if ($siteDeliveryData) {
                                $siteDeliveryQuestion = $siteDeliveryData->siteQuestion;

                                $siteDeliveryData->update([
                                    'value' => strtolower($indicatorValue['value']) == 'yes' ? 1 : 0,
                                    'answer_remark' => $indicatorValue['remarks'],
                                    'overall_remark' => $indicatorValue['text'],
                                ]);
                            }
                        }

                        if (!$siteDeliveryQuestion) {
                            $questionArray = [
                                'instance_id' => $instance->id,
                                'site_delivery_id' => $serviceSiteDelivery->id,
                                'question_id' => $indicatorValue['question_id'],
                                'question_list_id' => $indicatorValue['question_list_id'],
                                'question_type' => 'yes-no',
                                'part' => 'part-1',
                                'type' => 'a',
                            ];
                            $siteDeliveryQuestion = SiteDeliveryQuestions::create($questionArray);
                        }

                        if (!$siteDeliveryData)
                            $siteDeliveryData = SiteDeliveryData::create([
                                'site_delivery_questions_id' => $siteDeliveryQuestion->id,
                                'instance_id' => $instance->id,
                                'indicator_id' => $indicatorValue['indicator_id'],
                                'question_id' => $indicatorValue['question_id'],
                                'question_list_id' => $indicatorValue['question_list_id'],
                                'value' => strtolower($indicatorValue['value']) == 'yes' ? 1 : 0,
                                'answer_remark' => $indicatorValue['remarks'],
                                'overall_remark' => $indicatorValue['text'],
                            ]);

                        if ($request->get('question_detail') && isset($request->get('question_detail')[$indicatorValue['question_list_id']])) {
                            $siteDeliveryQuestion->question_detail = $request->get('question_detail')[$indicatorValue['question_list_id']];
                            $siteDeliveryQuestion->save();
                        }

                        array_push($this->siteDeliveryQuestionUpdateIdsArray, $siteDeliveryQuestion->id);
                        array_push($this->siteDeliveryDataUpdateIdsArray, $siteDeliveryData->id);


                    }
                }
            }
        }
    }

    public function storeTypeBData($partType, $instance, $serviceSiteDelivery, $request)
    {
        if (isset($partType['b'])) {
            foreach ($partType['b'] as $questionId => $indicatorsArray) {
                if (count($indicatorsArray) > 0) {
                    $siteDeliveryQuestion = null;
                    foreach ($indicatorsArray as $indicatorValue) {

                        $compareData = 0;
                        if ((float) $indicatorValue['value_b'] > 0 && (float) $indicatorValue['value_b'] > 0)
                            $compareData = round(((float) $indicatorValue['value_a'] / (float) $indicatorValue['value_b']) * 100, 2);

                        $siteDeliveryData = null;
                        if (isset($indicatorValue['site_delivery_id']) && $indicatorValue['site_delivery_id'])
                        {
                            $siteDeliveryData = SiteDeliveryData::find($indicatorValue['site_delivery_id']);

                            if ($siteDeliveryData) {
                                $siteDeliveryQuestion = $siteDeliveryData->siteQuestion;

                                $siteDeliveryData->update([
                                    'value' => $indicatorValue['value_a'] ? $indicatorValue['value_a'] : 0,
                                    'value_2' => $indicatorValue['value_b'] ? $indicatorValue['value_b'] : 0,
                                    'compare_result' => $compareData,
                                    'answer_remark' => $indicatorValue['value_remarks'],
                                ]);
                            }
                        }
                        if (!$siteDeliveryQuestion) {
                            $questionArray = [
                                'instance_id' => $instance->id,
                                'site_delivery_id' => $serviceSiteDelivery->id,
                                'question_id' => $indicatorValue['question_id'],
                                'question_list_id' => $indicatorValue['question_list_id'],
                                'question_type' => 'compare',
                                'part' => 'part-1',
                                'type' => 'b',
                            ];
                            $siteDeliveryQuestion = SiteDeliveryQuestions::create($questionArray);
                        }
                        if (!$siteDeliveryData)
                            $siteDeliveryData = SiteDeliveryData::create([
                                'site_delivery_questions_id' => $siteDeliveryQuestion->id,
                                'instance_id' => $instance->id,
                                'indicator_id' => $indicatorValue['indicator_id'],
                                'question_id' => $indicatorValue['question_id'],
                                'question_list_id' => $indicatorValue['question_list_id'],
                                'value' => $indicatorValue['value_a'] ? $indicatorValue['value_a'] : 0,
                                'value_2' => $indicatorValue['value_b'] ? $indicatorValue['value_b'] : 0,
                                'compare_result' => $compareData,
                                'answer_remark' => $indicatorValue['value_remarks'],
                            ]);

                        if ($request->get('question_detail') && isset($request->get('question_detail')[$indicatorValue['question_list_id']])) {
                            $siteDeliveryQuestion->question_detail = $request->get('question_detail')[$indicatorValue['question_list_id']];
                            $siteDeliveryQuestion->save();
                        }
                        array_push($this->siteDeliveryQuestionUpdateIdsArray, $siteDeliveryQuestion->id);
                        array_push($this->siteDeliveryDataUpdateIdsArray, $siteDeliveryData->id);
                    }
                }
            }
        }
    }

    public function storeTypeCData($partType, $instance, $serviceSiteDelivery, $request)
    {
        if (isset($partType['c'])) {
            foreach ($partType['c'] as $questionId => $indicatorsArray) {
                if (count($indicatorsArray) > 0) {
                    $siteDeliveryQuestion = null;
                    foreach ($indicatorsArray as $indicatorValue) {
                        $siteDeliveryData = null;
                        if (isset($indicatorValue['site_delivery_id']) && $indicatorValue['site_delivery_id'])
                        {
                            $siteDeliveryData = SiteDeliveryData::find($indicatorValue['site_delivery_id']);

                            if ($siteDeliveryData) {
                                $siteDeliveryQuestion = $siteDeliveryData->siteQuestion;

                                $siteDeliveryData->update([
                                    'value' => $indicatorValue['value_a_a'] ? $indicatorValue['value_a_a'] : 0,
                                    'value_2' => isset($indicatorValue['value_b_a']) ? $indicatorValue['value_b_a'] : 0,
//                                    'value_3' => isset($indicatorValue['value_b_a']) ? $indicatorValue['value_b_a'] : 0,
//                                    'value_4' => isset($indicatorValue['value_b_b']) ? $indicatorValue['value_b_b'] : 0,
                                    'answer_remark' => isset($indicatorValue['value_remarks']) ? $indicatorValue['value_remarks'] : null,
                                ]);
                            }
                        }

                        if (!$siteDeliveryQuestion) {
                            $questionArray = [
                                'instance_id' => $instance->id,
                                'site_delivery_id' => $serviceSiteDelivery->id,
                                'question_id' => $indicatorValue['question_id'],
                                'question_list_id' => $indicatorValue['question_list_id'],
                                'question_type' => 'compare',
                                'part' => 'part-1',
                                'type' => 'c',
                                'sub_type' => isset($indicatorValue['sub_type']) ? $indicatorValue['sub_type'] : null,
                            ];
                            $siteDeliveryQuestion = SiteDeliveryQuestions::create($questionArray);
                        }


                        if (!$siteDeliveryData)
                            $siteDeliveryData = SiteDeliveryData::create([
                                'site_delivery_questions_id' => $siteDeliveryQuestion->id,
                                'instance_id' => $instance->id,
                                'indicator_id' => $indicatorValue['indicator_id'],
                                'question_id' => $indicatorValue['question_id'],
                                'question_list_id' => $indicatorValue['question_list_id'],
                                'value' => $indicatorValue['value_a_a'] ? $indicatorValue['value_a_a'] : 0,
                                'value_2' => isset($indicatorValue['value_b_a']) ? $indicatorValue['value_b_a'] : 0,
//                                'value_3' => isset($indicatorValue['value_b_a']) ? $indicatorValue['value_b_a'] : 0,
//                                'value_4' => isset($indicatorValue['value_b_b']) ? $indicatorValue['value_b_b'] : 0,
                                'answer_remark' => isset($indicatorValue['value_remarks']) ? $indicatorValue['value_remarks'] : null,
                            ]);

                        if ($request->get('question_detail') && isset($request->get('question_detail')[$indicatorValue['question_list_id']])) {
                            $siteDeliveryQuestion->question_detail = $request->get('question_detail')[$indicatorValue['question_list_id']];
                            $siteDeliveryQuestion->save();
                        }

                        array_push($this->siteDeliveryQuestionUpdateIdsArray, $siteDeliveryQuestion->id);
                        array_push($this->siteDeliveryDataUpdateIdsArray, $siteDeliveryData->id);

                    }
                }
            }
        }
    }

    public function saveSiteDeliveryPartTwoData(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $instance = Instance::FilterByStage()
                ->whereIn('instance.id', parent::getInstancesIdsByRole())
                ->where('id', $id)
                ->first();

            $redirectArray = $this->getRedirectPath($request, $id);

            if ($instance && $request->get('part-2') && isset($request->get('part-2')['type'])) {
                $partType = $request->get('part-2')['type'];
                $serviceSiteDelivery = $instance->siteDelivery;
                foreach ($partType as $questionValue)
                {
                    $siteDeliveryData = $siteDeliveryQuestion = null;
                    if (isset($questionValue['site_delivery_id']) && $questionValue['site_delivery_id'])
                    {
                        $siteDeliveryData = SiteDeliverySystemAssessment::find($questionValue['site_delivery_id']);

                        if ($siteDeliveryData) {
                            $siteDeliveryQuestion = $siteDeliveryData->siteQuestion;

                            $siteDeliveryData->update([
                                'value' => ((int)$questionValue['value'] > 3 || (int)$questionValue['value'] < 0) ? 0 : (int)$questionValue['value'],
                                'remarks' => $questionValue['remarks'],
                            ]);
                        }
                    }
                    if (!$siteDeliveryQuestion) {
                        $questionArray = [
                            'instance_id' => $instance->id,
                            'site_delivery_id' => $serviceSiteDelivery->id,
                            'question_id' => $questionValue['question_id'],
                            'question_list_id' => $questionValue['question_list_id'],
                            'question_type' => 'yes-no-partly',
                            'part' => 'part-2',
                            'type' => $questionValue['type'],
                        ];
                        $siteDeliveryQuestion = SiteDeliveryQuestions::create($questionArray);
                    }

                    if (!$siteDeliveryData) {
                        $siteDeliveryData = SiteDeliverySystemAssessment::create([
                            'site_delivery_questions_id' => $siteDeliveryQuestion->id,
                            'instance_id' => $instance->id,
                            'question_id' => $questionValue['question_id'],
                            'question_list_id' => $questionValue['question_list_id'],
                            'value' => ((int)$questionValue['value'] > 3 || (int)$questionValue['value'] < 0) ? 0 : (int)$questionValue['value'],
                            'remarks' => $questionValue['remarks'],
                        ]);
                    }

                    if ($request->get('question_detail') && isset($request->get('question_detail')[$questionValue['question_list_id']])) {
                        $siteDeliveryQuestion->question_detail = $request->get('question_detail')[$questionValue['question_list_id']];
                        $siteDeliveryQuestion->save();
                    }

                    array_push($this->siteDeliveryQuestionUpdateIdsArray, $siteDeliveryQuestion->id);
                    array_push($this->siteDeliveryDataUpdateIdsArray, $siteDeliveryData->id);
                }

                SiteDeliverySystemAssessment::where('instance_id', $instance->id)
                    ->whereNotIn('id', $this->siteDeliveryDataUpdateIdsArray)
                    ->delete();

                SiteDeliveryQuestions::where('instance_id', $instance->id)
                    ->where('part', 'part-2')
                    ->whereNotIn('id', $this->siteDeliveryQuestionUpdateIdsArray)
                    ->delete();

                if ($instance->built_stage == 'step-2') {
                    $instance->built_stage = 'step-3';
                    $instance->save();
                }
                DB::commit();

                Flash::success(trans($this->trans_path . 'general.status.part-2'));
                return redirect($redirectArray['redirectPath']);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t add part-2 data.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'Line: '.$e->getLine();
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('siteDeliveryData-add-failed', $message);
        }


        Flash::error(trans($this->trans_path . 'general.error.part-2'));
        return redirect()->route($this->base_route);
    }


    public function saveSiteDeliveryPartThreeData(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $instance = Instance::FilterByStage()
                ->whereIn('instance.id', parent::getInstancesIdsByRole())
                ->where('id', $id)
                ->first();
            if ($instance) {
                $partType = $request->get('plan_id');
                $serviceSiteDelivery = $instance->siteDelivery;
                $followUpIds = [];
                if ($partType) {
                    foreach ($partType as $key => $value) {
                        $siteDeliverFollowUp = null;
                        if ($plan_id = $request->get('plan_id')[$key]) {
                            $siteDeliverFollowUp = SiteDeliveryFollowUp::find($plan_id);
                            $siteDeliverFollowUp->update([
                                'question_id' => $request->get('questionId')[$key],
                                'weakness' => $request->get('identified')[$key],
                                'description' => $request->get('description')[$key],
                                'responsible' => $request->get('responsible')[$key],
                                'time_line' => $request->get('timeLine')[$key],
                                'time_line_eng' => $request->get('timeLineEng')[$key],
                                'sort_order' => $key + 1,
                            ]);
                        } else {
                            $siteDeliverFollowUp = SiteDeliveryFollowUp::create([
                                'instance_id' => $instance->id,
                                'question_id' => $request->get('questionId')[$key],
                                'site_delivery_id' => $serviceSiteDelivery ? $serviceSiteDelivery->id : 0,
                                'weakness' => $request->get('identified')[$key],
                                'description' => $request->get('description')[$key],
                                'responsible' => $request->get('responsible')[$key],
                                'time_line' => $request->get('timeLine')[$key],
                                'time_line_eng' => $request->get('timeLineEng')[$key],
                                'sort_order' => $key + 1,
                            ]);
                        }

                        array_push($followUpIds, $siteDeliverFollowUp->id);

                    }
                }

                SiteDeliveryFollowUp::where('instance_id', $instance->id)
                    ->where('site_delivery_id', $serviceSiteDelivery->id)
                    ->whereNotIn('id', $followUpIds)
                    ->delete();

                if ($request->has('competed-status') && $instance->built_stage == 'step-3') {
                    $instance->built_stage = 'step-4';
                    $instance->save();
                }
                DB::commit();

                Flash::success(trans($this->trans_path . 'general.status.part-3'));
                return redirect()->route($this->base_route);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t add part-3 data.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'Line: '.$e->getLine();
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('siteDeliveryData-add-failed', $message);
        }


        Flash::error(trans($this->trans_path . 'general.error.part-3'));
        return redirect()->route($this->base_route);
    }


}