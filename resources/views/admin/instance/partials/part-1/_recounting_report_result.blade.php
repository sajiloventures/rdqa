<div class="smart-form">
    <table class="table table-hovered table-bordered table-condensed">
        <thead>
            <tr>
                <td colspan="2">
                    <strong>{{ strtoupper($data['questions']['part-1']['type']['a']['key']) }}: {{ $data['questions']['part-1']['type']['a']['name'] }}</strong>
                    <p>{{ $data['questions']['part-1']['type']['a']['description'] }}</p>
                </td>
                @foreach($data['indicators'] as $indicator)
                    <th style="width: 100px;">{{ $indicator->name }}</th>
                @endforeach
            </tr>
        </thead>
        @foreach($data['questions']['part-1']['type']['a']['question']->questionList as $question)
            @php $remarksHtml = $textHtml = ''; @endphp
            <tr>
                <td rowspan="2" width="10">{{ ++$questionNumber }}</td>
                <td>
                    @if($question->question_note)
                        <p style="font-size: 10px;">({{ $question->question_note }})</p>
                    @endif
                    {{ $question->question }}
                    <div style="display: none">
                        <input type="hidden" name="question_detail[{{$question->id}}]" value="{{serialize($question->toArray())}}">
                    </div>
                </td>
                @foreach($data['indicators'] as $indicator)
                    <td>
                        @php
                            $selectedSiteDeliveryData = null;
                            $qType = $data['questions']['part-1']['type']['a'];
                            if (isset($qType['data']) && isset($qType['data'][$question->id]) && isset($qType['data'][$question->id][$indicator->indicator_id])) {
                                $selectedSiteDeliveryData = $qType['data'][$question->id][$indicator->indicator_id];
                            }
                        @endphp
                        <input type="hidden" name="part-1[type][a][{{$question->id}}][{{$indicator->indicator_id}}][site_delivery_id]" value="{{$selectedSiteDeliveryData ? $selectedSiteDeliveryData->id : null}}">
                        <input type="hidden" name="part-1[type][a][{{$question->id}}][{{$indicator->indicator_id}}][indicator_id]" value="{{$indicator->indicator_id}}">
                        <input type="hidden" name="part-1[type][a][{{$question->id}}][{{$indicator->indicator_id}}][question_id]" value="{{$question->question_id}}">
                        <input type="hidden" name="part-1[type][a][{{$question->id}}][{{$indicator->indicator_id}}][question_list_id]" value="{{$question->id}}">
                        {!! AppHelper::getInputs('part-1[type][a][' . $question->id . '][' . $indicator->indicator_id . '][value]', 'yes-no', '', '', ($selectedSiteDeliveryData ? $selectedSiteDeliveryData->value : null)) !!}
                        <br />
                        {!! AppHelper::getInputs('part-1[type][a][' . $question->id . '][' . $indicator->indicator_id . '][remarks]', 'text', 'कैफियत', 'class="form-control colRemarks"', $selectedSiteDeliveryData ? $selectedSiteDeliveryData->answer_remark : null) !!}
                    </td>
                    @php
                        $remarksHtml .= '<td>' .
                                AppHelper::getInputs('part-1[type][a][' . $question->id . '][' . $indicator->indicator_id . '][text]', 'text', '', '', $selectedSiteDeliveryData ? $selectedSiteDeliveryData->overall_remark : null) .
                            '</td>';
                    @endphp
                @endforeach
            </tr>
            <tr>
                <td>{{ $question->if_not_question }}</td>
                {!! $remarksHtml !!}
            </tr>
        @endforeach

    </table>
</div>