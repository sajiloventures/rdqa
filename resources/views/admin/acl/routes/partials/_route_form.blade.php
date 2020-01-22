<fieldset>
    <div class="row">
        <section class="col col-10">
            {!! Form::label('method', trans($admin_trans_path.'general.columns.method')) !!}
    {!! Form::text('method', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.method')]) !!}
        </section>
    </div>
    <div class="row">
        <section class="col col-10">
            {!! Form::label('path', trans($admin_trans_path.'general.columns.path')) !!}
    {!! Form::text('path', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.path')]) !!}
        </section>
    </div>
    <div class="row">
        <section class="col col-10">
            {!! Form::label('name', trans($admin_trans_path.'general.columns.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.name')]) !!}
        </section>
    </div>
    <div class="row">
        <section class="col col-10">
            {!! Form::label('action_name', trans($admin_trans_path.'general.columns.action_name')) !!}
    {!! Form::text('action_name', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.action_name')]) !!}
        </section>
    </div>
</fieldset>