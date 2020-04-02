<div class="smart-form">
    <table class="table table-hovered table-bordered table-condensed">
        <thead>
        <tr>
            <td colspan="2">
                <strong>{{ strtoupper($data['questions']['part-1']['type']['c']['key']) }}: {{ $data['questions']['part-1']['type']['c']['name'] }}</strong>
                <small>{{ $data['questions']['part-1']['type']['c']['description'] }}</small>
            </td>

            @foreach($data['indicators'] as $indicator)
                <th style="width: 130px;">{{ $indicator->name }}</th>
            @endforeach
        </tr>
        </thead>
    </table>
    @php $initialCount= $firstCount =0; @endphp
    @foreach($data['questions']['part-1']['type']['c']['type'] as $crossCheck)
        @php $questionNumber = 0; @endphp
        <table class="table table-hovered table-bordered table-condensed">
            <thead>
            <tr>
                <td colspan="2">
                    <strong>{{ $crossCheck['name'] }}</strong>
                    <p>{{ $crossCheck['description'] }}</p>
                </td>
                @php ++$firstCount; @endphp
                @foreach($data['indicators']->toArray() as $indicator)
                    <td style="width: 130px;">
                        @if($indicator['cross_check_' . $firstCount . '_a_id'] && isset($data['cross_checks'][$indicator['cross_check_' . $firstCount . '_a_id']]))
                            {{ $data['cross_checks'][$indicator['cross_check_' . $firstCount . '_a_id']] }}
                        @endif
                    </td>
                @endforeach
            </tr>
            </thead>
            <tbody>
                @if($crossCheck['question']->sub_type == 'cross-check-3')
                    @include($view_path . '.partials.part-1._cross_check_3')
                @else
                    @foreach($crossCheck['question']->questionList as $question)
                        @php $compare_a = $compare_b = $compare_result = $remarks = ''; @endphp
                        <tr>
                            <td width="10">{{ ++$initialCount . '.' . ++$questionNumber }}</td>
                            <td>
                                <input type="hidden" name="question_detail[{{$question->id}}]" value="{{serialize($question->toArray())}}">
                                {{ $question->question }}<strong>[A]</strong>
                            </td>
                            @foreach($data['indicators'] as $indicator)
                                @if($indicator['cross_check_' . $firstCount . '_a_id'] && isset($data['cross_checks'][$indicator['cross_check_' . $firstCount . '_a_id']]))

                                    <td style="vertical-align: bottom;">
                                        @php
                                            $selectedSiteDeliveryData = null;
                                            $qType = $crossCheck;
                                            if (isset($qType['data']) && isset($qType['data'][$question->id]) && isset($qType['data'][$question->id][$indicator->indicator_id])) {
                                                $selectedSiteDeliveryData = $qType['data'][$question->id][$indicator->indicator_id];
                                            }
                                        @endphp
                                        <input type="hidden" name="part-1[type][c][{{$question->id}}][{{$indicator->indicator_id}}][site_delivery_id]" value="{{$selectedSiteDeliveryData ? $selectedSiteDeliveryData->id : null}}">
                                        <input type="hidden" name="part-1[type][c][{{$question->id}}][{{$indicator->indicator_id}}][indicator_id]" value="{{$indicator->indicator_id}}">
                                        <input type="hidden" name="part-1[type][c][{{$question->id}}][{{$indicator->indicator_id}}][question_id]" value="{{$question->question_id}}">
                                        <input type="hidden" name="part-1[type][c][{{$question->id}}][{{$indicator->indicator_id}}][question_list_id]" value="{{$question->id}}">
                                        <input type="hidden" name="part-1[type][c][{{$question->id}}][{{$indicator->indicator_id}}][sub_type]" value="cross-check-{{$initialCount}}">
                                        <input type="number" min="0" name="part-1[type][c][{{$question->id}}][{{$indicator->indicator_id}}][value_a_a]" class="form-control compare_a_a" data-indicator="{{$indicator->indicator_id}}" value="{{$selectedSiteDeliveryData && $selectedSiteDeliveryData->value_2 != null ? $selectedSiteDeliveryData->value : null}}">
                                    </td>
                                    @php
                                        $compare_b .= '<td style="position: relative; vertical-align: bottom;">' .
                                                AppHelper::getInputs('part-1[type][c][' . $question->id . '][' . $indicator->indicator_id . '][value_b_a]', 'number', '', 'class="form-control compare_b_a" min="0" data-indicator="' . $indicator->indicator_id . '"', $selectedSiteDeliveryData ? $selectedSiteDeliveryData->value_2 : null) .
                                            '</td>';

                                        $comparePercentA = null;
                                        $comparePercentB = null;
                                        if ($selectedSiteDeliveryData){
                                            $comparePercentA = AppHelper::getPercentage($selectedSiteDeliveryData->value_2, $selectedSiteDeliveryData->value) . '%';
                                        }
                                        $compare_result .= '<td style="vertical-align:bottom;"><span class="compare_result_' . $indicator->indicator_id . '_a">' . $comparePercentA . '</span></td>';
                                        $remarks .= '<td>' .
                                                AppHelper::getInputs('part-1[type][c][' . $question->id . '][' . $indicator->indicator_id . '][value_remarks]', 'text', 'कैफियत',  'class="form-control colRemarks"', $selectedSiteDeliveryData ? $selectedSiteDeliveryData->answer_remark : null) .
                                            '</td>';
                                    @endphp
                                @else

                                    @php
                                        $compare_b .= '<td>&nbsp;</td>';
                                        $compare_result .= '<td>&nbsp;</td>';
                                        $remarks .= '<td>&nbsp;</td>';
                                    @endphp
                                    <td>&nbsp;</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <td width="10">{{ $initialCount . '.' . ++$questionNumber }}</td>
                            <td>{{ $question->question_note }}<strong>[B]</strong></td>
                            {!! $compare_b !!}
                        </tr>
                        <tr>
                            <td width="10">{{ $initialCount . '.' . ++$questionNumber }}</td>
                            <td>{{ $question->if_not_question }}<strong>[A/B]</strong></td>
                            {!! $compare_result !!}
                        </tr>
                        <tr>
                            <td width="10"></td>
                            <td>{{ $question->compare_result }}</td>
                            {!! $remarks !!}
                        </tr>
                    @endforeach
                @endif
            </tbody>

        </table>
    @endforeach
</div>