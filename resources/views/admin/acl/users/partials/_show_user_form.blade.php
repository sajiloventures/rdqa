 <ul class="nav nav-tabs in" id="myTab">
    <li class="nav-item active">
        <a  href="#tab_details" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.details') !!}</a>
    </li>
    <li class="nav-item">
        <a  href="#tab_options" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.options') !!}</a>
    </li>
    <li class="nav-item">
        <a  href="#tab_roles" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.roles') !!}</a>
    </li>
    <li class="nav-item">
        <a  href="#tab_permssions" data-toggle="tab">{!! trans($admin_trans_path.'general.tabs.perms') !!}</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab_details">
        @include($view_path.'.tabs.general_details_tab_content')
    </div>
    <div class="tab-pane" id="tab_options">
        @include($view_path.'.tabs.options_tab_content')
    </div>
    <div class="tab-pane" id="tab_roles">
        @include($view_path.'.tabs.roles_tab_content')
    </div>
    <div class="tab-pane" id="tab_permssions">
        @include($view_path.'.tabs.permission_tab_content')
    </div>
</div>