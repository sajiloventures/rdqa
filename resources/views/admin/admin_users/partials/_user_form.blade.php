<div class="smart-form">
    <fieldset>
        <div class="row">
            <section class="col col-6">
                <label class="label">{{ trans($admin_trans_path.'general.columns.first_name') }}</label>
                <label class="input">
                    <i class="icon-prepend fa fa-user">
                    </i>
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.first_name')]) !!}
                </label>
            </section>
            <section class="col col-6">
                <label class="label">{{ trans($admin_trans_path.'general.columns.last_name') }}</label>
                <label class="input">
                    <i class="icon-prepend fa fa-user">
                    </i>
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.last_name')]) !!}
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label">{{ trans($admin_trans_path.'general.columns.username') }}</label>
                <label class="input">
                    <i class="icon-prepend fa fa-user">
                    </i>
                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.username')]) !!}
                </label>
            </section>
            <section class="col col-6">

                <label class="label">{{ trans($trans_path.'general.columns.user_role') }}</label>
                <label class="select">
                    {!! Form::select('user_role', AppHelper::getUserRoles(), null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.user_role'), 'readonly' => (isset($user) && $user->id == auth()->user()->id ? true : false)]) !!}
                </label>
            </section>
        </div>
        {{--
        <div class="row">
            <section class="col col-4" style="display: none;">
                <label class="label">{{ trans($trans_path.'general.columns.province_user') }}</label>
                <label class="select">
                    {!! Form::select('province_user_id', $data['province_users'], $data['province_user_id'] ? $data['province_user_id'] : null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.province_user')]) !!}
                </label>
            </section>
            <section class="col col-4" style="display: none;">
                <label class="label">{{ trans($trans_path.'general.columns.district_user') }}</label>
                <label class="select">
                    {!! Form::select('district_user_id', $data['users_list'], $data['district_user_id'] ? $data['district_user_id'] : null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.district_user')]) !!}
                </label>
            </section>
            <section class="col col-4" style="display: none;">
                <label class="label">{{ trans($trans_path.'general.columns.palika_user') }}</label>
                <label class="select">
                    {!! Form::select('palika_user_id', $data['users_list'], $data['palika_user_id'] ? $data['palika_user_id'] : null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.palika_user')]) !!}
                </label>
            </section>
        </div>
            --}}

        <section>
            <label class="label">{{ trans($admin_trans_path.'general.columns.email') }}</label>
            <label class="input">
                <i class="icon-prepend fa fa-envelope-o">
                </i>
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.email'), 'readonly' => (isset($user) && $user->id == auth()->user()->id ? true : false)]) !!}
            </label>
        </section>

        <div class="row showHideDistrict" style="display: none;">
            <section class="col col-3 data-province">
                <label class="label">{{ trans($trans_path.'general.columns.province') }}</label>
                {!! Form::select('province', $province , null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.province')]) !!}
            </section>
            <section class="col col-3 data-district">
                <label class="label">{{ trans($trans_path.'general.columns.district') }}</label>
                {!! Form::select('district', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.district')]) !!}
            </section>
            <section class="col col-3 data-palika">
                <label class="label">{{ trans($trans_path.'general.columns.municipality') }}</label>
                {!! Form::select('municipality', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.municipality')]) !!}
            </section>
            <section class="col col-3 data-post">
                <label class="label">{{ trans($trans_path.'general.columns.health_post_name') }}</label>
                {!! Form::select('health_post_name', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.health_post_name')]) !!}
            </section>
        </div>

        {{--<div class="row">--}}
            {{--<section class="col col-4">--}}
                {{--<label class="label">{{ trans($trans_path.'general.columns.province') }}</label>--}}
                {{--{!! Form::select('province', $province , null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.province')]) !!}--}}
            {{--</section>--}}
            {{--<section class="col col-4">--}}
                {{--<label class="label">{{ trans($trans_path.'general.columns.district') }}</label>--}}
                {{--{!! Form::select('district', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.district')]) !!}--}}
            {{--</section>--}}
            {{--<section class="col col-4">--}}
                {{--<label class="label">{{ trans($trans_path.'general.columns.municipality') }}</label>--}}
                {{--{!! Form::select('municipality', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.municipality')]) !!}--}}
            {{--</section>--}}
        {{--</div>--}}
        <div class="row">
            <section class="col col-6">
                <label class="label">{{ trans($admin_trans_path.'general.columns.password') }}</label>
                <label class="input">
                    <i class="icon-prepend fa fa-lock">
                    </i>
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.password')]) !!}
                </label>
            </section>
            <section class="col col-6">
                <label class="label">{{ trans($admin_trans_path.'general.columns.password_confirmation') }}</label>
                <label class="input">
                    <i class="icon-prepend fa fa-lock">
                    </i>
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.password_confirmation')]) !!}
                </label>
            </section>
        </div>
        <section>
            <label class="label">{{ trans($trans_path.'general.columns.user-status') }}</label>
            <div class="checkbox">
                <label>
                    <input name="enabled" type="checkbox" class="checkbox" value="1" {{ isset($user) && $user->enabled == 0 ? null : 'checked' }} {{ isset($user) && $user->id == auth()->user()->id ? 'readonly' : null }} />
{{--                        {!! Form::checkbox('enabled', 1, true, ['class' => 'checkbox', 'readonly' => (isset($user) && $user->id == auth()->user()->id ? true : false)]) !!}--}}
                    <span>{{ trans($admin_trans_path.'general.columns.status') }} </span>
                </label>
            </div>
        </section>
    </fieldset>
</div>

