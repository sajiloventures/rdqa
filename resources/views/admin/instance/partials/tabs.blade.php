<div class="form-bootstrapWizard">
    <ul class="bootstrapWizard form-wizard">
        @if($siteFollowUp)
            <li class="active" data-target="#step{{$tabCount}}" style="width: {{$siteFollowUp?33:50}}%;">
                <a href="#tab{{$tabCount}}" data-toggle="tab"> <span class="step">{{$tabCount++}}</span> <span class="title">Previous action plan</span> </a>
            </li>
        @endif
        <li class="{{!$siteFollowUp?'active':null}}" data-target="#step{{$tabCount}}"  style="width: {{$siteFollowUp?33:50}}%;">
            <a href="#tab{{$tabCount}}" data-toggle="tab"> <span class="step">{{$tabCount++}}</span> <span class="title">Basic information</span> </a>
        </li>
        <li data-target="#step{{$tabCount}}"  style="width: {{$siteFollowUp?33:50}}%;">
            <a href="#tab{{$tabCount}}" data-toggle="tab"> <span class="step">{{$tabCount}}</span> <span class="title">Indicator setup</span> </a>
        </li>
    </ul>
    <div class="clearfix"></div>
</div>