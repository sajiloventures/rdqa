<div class="smart-form">
    <fieldset>
        <div class="row">
            <section class="col col-6">
                <label class="input">
                    <i class="icon-prepend fa fa-user">
                    </i>
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.first_name')]) !!}
                </label>
            </section>
            <section class="col col-6">
                <label class="input">
                    <i class="icon-prepend fa fa-user">
                    </i>
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.last_name')]) !!}
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="input">
                    <i class="icon-prepend fa fa-user">
                    </i>
                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.username')]) !!}
                </label>
            </section>
            <section class="col col-6">
                <label class="input">
                    <i class="icon-prepend fa fa-envelope-o">
                    </i>
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.email')]) !!}
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="input">
                    <i class="icon-prepend fa fa-lock">
                    </i>
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.password')]) !!}
                </label>
            </section>
            <section class="col col-6">
                <label class="input">
                    <i class="icon-prepend fa fa-lock">
                    </i>
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.password_confirmation')]) !!}
                </label>
            </section>
        </div>
    </fieldset>
</div>