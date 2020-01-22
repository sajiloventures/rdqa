<div class="form-bootstrapWizard">
    <ul class="bootstrapWizard form-wizard">
        @php $count=1; @endphp
        @foreach($data['questions']['part-1']['type'] as $key => $question)
            <li class="{{ $count == 1 ? 'active': '' }}" data-target="#step{{$count}}" style="width: 33%">
                <a href="#tab{{$count}}" data-toggle="tab"> <span class="step">{{$count++}}</span> <span class="title">{{$question['name']}}</span> </a>
            </li>
        @endforeach
    </ul>
    <div class="clearfix"></div>
</div>

{{--<div class="form-bootstrapWizard">--}}
    {{--<ul class="bootstrapWizard form-wizard">--}}
        {{--<li class="active" data-target="#step1">--}}
            {{--<a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">1</span> </a>--}}
        {{--</li>--}}
        {{--<li data-target="#step2">--}}
            {{--<a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">2</span> </a>--}}
        {{--</li>--}}
        {{--<li data-target="#step3">--}}
            {{--<a href="#tab3" data-toggle="tab"> <span class="step">2</span> <span class="title">3</span> </a>--}}
        {{--</li>--}}
    {{--</ul>--}}
    {{--<div class="clearfix"></div>--}}
{{--</div>--}}