<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link " href="#tab_details" data-toggle="tab">
            {!! trans($admin_trans_path.'general.tabs.details') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab_options" data-toggle="tab">
            {!! trans($admin_trans_path.'general.tabs.options') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab_routes" data-toggle="tab">
            {!! trans($admin_trans_path.'general.tabs.routes') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab_roles" data-toggle="tab">
            {!! trans($admin_trans_path.'general.tabs.roles') !!}
        </a>
    </li>
</ul>

<div class="card-block tab-content">
    <div class="tab-pane active" id="tab_details">
        @include($view_path.'tabs.general_details_tab_content')
    </div>
    <div class="tab-pane" id="tab_options">
        @include($view_path.'tabs.options_tab_content')
    </div>
    <div class="tab-pane" id="tab_routes">
        @include($view_path.'tabs.routes_tab_content')
    </div>
    <div class="tab-pane" id="tab_roles">
        @include($view_path.'tabs.roles_tab_content')
    </div>
</div>