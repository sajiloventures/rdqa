<ul class="nav nav-tabs in" id="myTab">
    <li class="nav-item active">
        <a  href="#tab_basic" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.basic') !!}</a>
    </li>
    <li class="nav-item">
        <a  href="#tab_advanced" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.advanced') !!}</a>
    </li>
    <li class="nav-item">
        <a  href="#tab_smtp" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.smtp') !!}</a>
    </li>
    <li class="nav-item">
        <a  href="#tab_social_net" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.social_net') !!}</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab_basic">
        @include($view_path.'.tabs.basic')
    </div>
    <div class="tab-pane" id="tab_advanced">
        @include($view_path.'.tabs.advance')
    </div>
    <div class="tab-pane" id="tab_smtp">
        @include($view_path.'.tabs.smtp')
    </div>
    <div class="tab-pane" id="tab_social_net">
        @include($view_path.'.tabs.social')
    </div>
</div>