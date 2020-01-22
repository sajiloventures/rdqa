<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1"
     data-widget-colorbutton="false"
     data-widget-editbutton="false"
     data-widget-deletebutton="false"
     data-widget-fullscreenbutton="false"
     data-widget-custombutton="false"
     data-widget-collapsed="false"
     data-widget-sortable="false">
    <header>

        <h2>System Assessment </h2>
        <div class="pull-right" style="margin-top: -5px;">
            <a href="javascript:void(0)" class="btn btn-xs" style="background: #24c524b3; color: #000000;">Yes - completely(2.5-3.0)</a>
            <a href="javascript:void(0)" class="btn btn-xs" style="background: yellow; color: #000000;">Partly(1.5-<2.5)</a>
            <a href="javascript:void(0)" class="btn btn-xs" style="background: #f06c6c; color: #000000;">No-not at all(<1.5)</a>
        </div>
    </header>

    <!-- widget div-->
    <div>
        <!-- widget content -->
        <div class="widget-body" style="overflow: scroll;">

            <table class="table table-striped table-condensed table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th class="text-center">SN</th>
                        <th class="text-center">Name</th>
                        @php $assessmentData = []; $assessmentCount= 0; $numberOfSysAssessment = count($data['system-assessment']); @endphp
                        @foreach($data['system-assessment'] as $sa)
                            <th class="text-center" data-system-id="{{++$assessmentCount}}">{!! $sa->name !!}</th>
                            @php
                                $assessmentData += [
                                    $assessmentCount=>[
                                        'remarks' => '',
                                        'value' => 0
                                    ],
                                ];
                            @endphp
                        @endforeach
                        <th class="text-center" data-system-id="{{++$assessmentCount}}">Average</th>
                        @php
                            $assessmentData += [
                                $assessmentCount=>[
                                        'remarks' => '',
                                        'value' => 0
                                    ]
                            ];
                        @endphp


                    </tr>
                </thead>

                <tbody>
                    @php $instanceCount = $assessmentCount = 0; @endphp
                    @foreach($data['system-assessment-list'] as $instance)
                        <tr>
                            @php $averageAssessment = $assessmentCount = 0; @endphp
                            <td>{{ ++$instanceCount }}</td>
                            <td>{{ $instance['name'] }}</td>
                            @foreach($instance['assessment'] as $assessment)
                                @php

                                    $eachAvg = round($assessment->total / $assessment->number, 2);
                                    if ($eachAvg >= 2.5)
                                        $color = '#24c524b3';
                                    else if ($eachAvg < 1.5)
                                        $color = '#f06c6c';
                                    else
                                        $color = 'yellow';

                                    $averageAssessment += $eachAvg;
                                    $assessmentData[++$assessmentCount]['value'] += $eachAvg;
                                    if ($assessment->all_remarks)
                                    $assessmentData[$assessmentCount]['remarks'] .= $assessment->all_remarks . ', ';
                                @endphp
                                <td  style="background-color: {{AppHelper::getSystemAssessmentColor($eachAvg)}};">{!! $eachAvg !!}</td>
                            @endforeach
                            <td style="background-color: {{AppHelper::getSystemAssessmentColor(round($averageAssessment / $numberOfSysAssessment, 2))}};">{{ round($averageAssessment / $numberOfSysAssessment, 2) }}</td>
                            @php
                                $assessmentData[++$assessmentCount]['value'] += round($averageAssessment / $numberOfSysAssessment, 2);
                            @endphp
                        @endforeach
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center">Average (by functional area)</th>
                        @foreach($assessmentData as $avg)
                            <th class="text-center" style="background: {{AppHelper::getSystemAssessmentColor(AppHelper::getPercentage($avg['value'], $instanceCount, 2, false))}};">{{AppHelper::getPercentage($avg['value'], $instanceCount, 2, false)}}</th>
                        @endforeach

                    </tr>
                </tbody>
                @if(isset($data['instance']))
                    <tbody>
                        <tr>
                            <th colspan="9">Remarks</th>
                        </tr>
                        <tr class="bg-color-grayDark" style="color: white;">
                            <td>SN</td>
                            <td colspan="4">Question</td>
                            <td>Answer</td>
                            <td colspan="2">Remark</td>
                        </tr>
                        @php
                            $questionId = 0;
                            $countQues = 0;
                            $yesNoValue = config('rdqa.yes-no');
                        @endphp
                        @foreach($data['instanceSystemAssessment'] as $avg)
                            @if($questionId != $avg->question_id)
                                <tr>
                                    <th colspan="9" class="bg-danger">{{ $avg->question->type_name }}</th>
                                </tr>
                                @php $questionId = $avg->question_id; $countQues = 0;  @endphp
                            @endif
                            <tr class="text-left">
                                @php
                                    $question = null;
                                    if ($avg->siteQuestion) {
                                        $questionDetail = unserialize($avg->siteQuestion->question_detail);
                                        $question = $questionDetail['question'];

                                    }
                                @endphp
                                <td>{{ ++$countQues }}</td>
                                <td colspan="4">{{ $question }}</td>
                                <td>{{ isset($yesNoValue[$avg->value]) ? $yesNoValue[$avg->value] : '-' }}</td>
                                <td colspan="2">{{$avg->remarks}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif

            </table>

        </div>
        <!-- end widget content -->

    </div>
    <!-- end widget div -->

</div>