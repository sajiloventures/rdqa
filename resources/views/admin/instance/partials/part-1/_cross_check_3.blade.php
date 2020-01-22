@php ++$initialCount; @endphp
@foreach($crossCheck['question']->questionList()->orderBy('sort_order')->get() as $question)
    @php $compare_result = $remarks = ''; @endphp
    <tr>
        <td width="10">{{ $initialCount . '.' . ++$questionNumber }}</td>
        <td>
            <input type="hidden" name="question_detail[{{$question->id}}]" value="{{serialize($question->toArray())}}">
            {{ $question->question }}
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
                    <input type="number" min="0" name="part-1[type][c][{{$question->id}}][{{$indicator->indicator_id}}][value_a_a]" class="form-control compare_3_a" data-indicator="{{$indicator->indicator_id}}" value="{{$selectedSiteDeliveryData && $selectedSiteDeliveryData->value != null ? $selectedSiteDeliveryData->value : null}}" required>
                </td>
                @php
                    $compare_result .= '<td style="vertical-align:bottom;"><span class="compare_result_' . $indicator->indicator_id . '_a"></span></td>';
                    $remarks .= '<td>' .
                            AppHelper::getInputs('part-1[type][c][' . $question->id . '][' . $indicator->indicator_id . '][value_remarks]', 'text', 'कैफियत', 'class="form-control colRemarks"', $selectedSiteDeliveryData ? $selectedSiteDeliveryData->answer_remark : null) .
                        '</td>';
                @endphp
            @else

                @php
                    $compare_result .= '<td>&nbsp;</td>';
                    $remarks .= '<td>&nbsp;</td>';
                @endphp
                <td>&nbsp;</td>
            @endif
        @endforeach
    </tr>
@endforeach
<tr>
    <td width="10">{{ $initialCount . '.' . ++$questionNumber }}</td>
    <td>
        {{ $question->question_note }}
    </td>
    {!! $compare_result !!}
</tr>
<tr>
    <td width="10"></td>
    <td></td>
    {!! $remarks !!}
</tr>