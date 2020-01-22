<div class="smart-form">
    <table class="table table-hovered table-bordered table-condensed">
        <thead>
        <tr>
            <td colspan="2">
                <strong>{{ strtoupper($data['questions']['part-1']['type']['b']['key']) }}: {{ $data['questions']['part-1']['type']['b']['name'] }}</strong>
                <p>{{ $data['questions']['part-1']['type']['b']['description'] }}</p>
            </td>
            @foreach($data['indicators'] as $indicator)
                <th style="width: 100px;">{{ $indicator->name }}</th>
            @endforeach
        </tr>
        </thead>
        @foreach($data['questions']['part-1']['type']['b']['question']->questionList as $question)
            @php $compare_a = $compare_b = $compare_result = $remarks = ''; @endphp
            <tr>
                <td width="10">{{ ++$questionNumber }}</td>
                <td>
                    <input type="hidden" name="question_detail[{{$question->id}}]" value="{{serialize($question->toArray())}}">
                    {{ $question->question }}
                </td>
                @foreach($data['indicators'] as $indicator)
                    <td>
                        @php
                            $selectedSiteDeliveryData = null;
                            $qType = $data['questions']['part-1']['type']['b'];
                            if (isset($qType['data']) && isset($qType['data'][$question->id]) && isset($qType['data'][$question->id][$indicator->indicator_id])) {
                                $selectedSiteDeliveryData = $qType['data'][$question->id][$indicator->indicator_id];
                            }
                        @endphp
                        <input type="hidden" name="part-1[type][b][{{$question->id}}][{{$indicator->indicator_id}}][site_delivery_id]" value="{{$selectedSiteDeliveryData ? $selectedSiteDeliveryData->id : null}}">
                        <input type="hidden" name="part-1[type][b][{{$question->id}}][{{$indicator->indicator_id}}][indicator_id]" value="{{$indicator->indicator_id}}">
                        <input type="hidden" name="part-1[type][b][{{$question->id}}][{{$indicator->indicator_id}}][question_id]" value="{{$question->question_id}}">
                        <input type="hidden" name="part-1[type][b][{{$question->id}}][{{$indicator->indicator_id}}][question_list_id]" value="{{$question->id}}">
                        <input type="number" min="0" name="part-1[type][b][{{$question->id}}][{{$indicator->indicator_id}}][value_a]" class="form-control compare_a" data-indicator="{{$indicator->indicator_id}}" value="{{$selectedSiteDeliveryData ? $selectedSiteDeliveryData->value : null}}">
{{--                        {!! AppHelper::getInputs('part-1[type][b][' . $question->id . '][' . $indicator->indicator_id . '][value_a]', 'number') !!}--}}
                    </td>
                    @php
                        $compare_b .= '<td>' .
                                AppHelper::getInputs('part-1[type][b][' . $question->id . '][' . $indicator->indicator_id . '][value_b]', 'number', '', 'class="form-control compare_b" min="0" data-indicator="' . $indicator->indicator_id . '"', ($selectedSiteDeliveryData ? $selectedSiteDeliveryData->value_2 : null)) .
                            '</td>';
                        $compare_result .= '<td class="compare_result_' . $indicator->indicator_id . '">' . ($selectedSiteDeliveryData ? $selectedSiteDeliveryData->compare_result . '%' : null) . '</td>';
                        $remarks .= '<td>' .
                                AppHelper::getInputs('part-1[type][b][' . $question->id . '][' . $indicator->indicator_id . '][value_remarks]', 'text', 'कैफियत',  'class="form-control colRemarks"', ($selectedSiteDeliveryData ? $selectedSiteDeliveryData->answer_remark : null)) .
                            '</td>';
                    @endphp
                @endforeach
            </tr>
            <tr>
                <td width="10">{{ ++$questionNumber }}</td>
                <td>{{ $question->question_note }}</td>
                {!! $compare_b !!}
            </tr>
            <tr>
                <td width="10">{{ ++$questionNumber }}</td>
                <td>{{ $question->if_not_question }}</td>
                {!! $compare_result !!}
            </tr>
            <tr>
                <td width="10">{{ ++$questionNumber }}</td>
                <td>{{ $question->compare_result }}</td>
                {!! $remarks !!}
            </tr>
        @endforeach

    </table>
</div>