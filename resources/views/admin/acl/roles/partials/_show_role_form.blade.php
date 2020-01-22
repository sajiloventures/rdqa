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
        <fieldset>
            <section>
                <div class="inline-group">
                    <label class="checkbox">
                        {!! Form::checkbox('resync_on_login', '1', $role->resync_on_login, ['disabled']) !!} 
                {!! trans($trans_path. 'general.columns.resync_on_login') !!}
                        <i>
                        </i>
                    </label>
                </div>
            </section>
        </fieldset>
        @include($view_path.'.tabs.options_tab_content')
    </div>
    <div class="tab-pane" id="tab_perms">
        <fieldset>
            <section>
                <div class="row">
            @foreach($perms as $perm)
                      @if($role->hasPerm($perm))
                    <div class="col col-lg-6">
                        <label class="checkbox">
                            <strong>
                                <i class="fa fa-check">
                                </i>
                                Route:
                            </strong>
                            {{ $perm->display_name }}
                        </label>
                    </div>
                    @endif                
             @endforeach
                </div>
            </section>
        </fieldset>
    </div>
    <div class="tab-pane" id="tab_users">
        @include($view_path.'.tabs.users_tab_content')
    </div>
</div>