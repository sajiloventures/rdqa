<div class="smart-form">
    <table class="table table-hovered table-bordered table-condensed">
        <thead>
        <tr>
            <td colspan="2">
                <strong>{{ $count }}: {{ $questionType['name'] }}</strong>
                <p>{{ $questionType['description'] }}</p>
            </td>
        </tr>
        </thead>
        @foreach($questionType['question']->questionList as $question)
            @php $remarks = ''; @endphp
            <tr>
                <td width="10">{{ ++$questionNumber }}</td>
                <td>
                    <input type="hidden" name="question_detail[{{$question->id}}]" value="{{serialize($question->toArray())}}">
                    {{ $question->question }}
                </td>
                <td>
                    @php
                        $selectedSiteDeliveryData = null;
                        $qType = $questionType;
                        if (isset($qType['data']) && isset($qType['data'][$question->id])) {
                            $selectedSiteDeliveryData = $qType['data'][$question->id];
                        }
                    @endphp
                    <input type="hidden" name="part-2[type][{{$question->id}}][site_delivery_id]" value="{{$selectedSiteDeliveryData ? $selectedSiteDeliveryData->id : null}}">
                    <input type="hidden" name="part-2[type][{{$question->id}}][type]" value="{{$questionType['key']}}">
                    <input type="hidden" name="part-2[type][{{$question->id}}][question_id]" value="{{$question->question_id}}">
                    <input type="hidden" name="part-2[type][{{$question->id}}][question_list_id]" value="{{$question->id}}">
                    {!! AppHelper::getInputs('part-2[type][' . $question->id . '][value]', 'yes-no-partly','', '', ($selectedSiteDeliveryData ? $selectedSiteDeliveryData->value : null)) !!}
                </td>
                <td>
                    {!! AppHelper::getInputs('part-2[type][' . $question->id . '][remarks]', 'text', 'कैफियत', 'class="form-control colRemarks"', ($selectedSiteDeliveryData ? $selectedSiteDeliveryData->remarks : null)) !!}
                </td>
            </tr>
        @endforeach

    </table>
</div>