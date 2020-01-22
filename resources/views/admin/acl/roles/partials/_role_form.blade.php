<ul class="nav nav-tabs in" id="myTab">
    <li class="nav-item active">
        <a data-toggle="tab" href="#tab_details">
            {!! trans($admin_trans_path.'general.tabs.details') !!}
        </a>
    </li>
    <li class="nav-item">
        <a data-toggle="tab" href="#tab_options">
            {!! trans($admin_trans_path.'general.tabs.options') !!}
        </a>
    </li>
    <li class="nav-item">
        <a data-toggle="tab" href="#tab_perms">
            {!! trans($admin_trans_path.'general.tabs.perms') !!}
        </a>
    </li>
    <li class="nav-item">
        <a data-toggle="tab" href="#tab_users">
            {!! trans($admin_trans_path.'general.tabs.users') !!}
        </a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="tab_details">

        @include($view_path.'.tabs.general_details_tab_content')
    </div>
    <div class="tab-pane" id="tab_options">
        @include($view_path.'.tabs.options_tab_content')
    </div>
    <div class="tab-pane" id="tab_perms">
        @include($view_path.'.tabs.permission_tab_content')
    </div>
    <div class="tab-pane" id="tab_users">
        @include($view_path.'.tabs.users_tab_content')
    </div>
</div>