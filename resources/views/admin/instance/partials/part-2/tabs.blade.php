<div class="form-bootstrapWizard">
    <ul class="bootstrapWizard form-wizard">
        @php $count=1; @endphp
        @foreach($data['questions']['part-2']['type'] as $key => $question)
            @if(count($question['question']->questionList) > 0)
                <li class="{{ $count == 1 ? 'active': '' }}" data-target="#step{{$count}}" style="width: {{floor(100/count($data['questions']['part-2']['type']))}}%">
                    <a href="#tab{{$count}}" data-toggle="tab"> <span class="step">{{$count++}}</span> <span class="title">{{$question['name']}}</span> </a>
                </li>
            @endif
        @endforeach
    </ul>
    <div class="clearfix"></div>
</div>