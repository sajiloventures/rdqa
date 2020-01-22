<?php $readonly = ($role->isEditable()) ? '' : 'readonly'; ?>
<fieldset>

    <div class="row">
        <section class="col col-6">
            {!! Form::label('name', trans($admin_trans_path.'general.columns.name')) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            {!! Form::label('display_name', trans($admin_trans_path.'general.columns.display_name')) !!}
            {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
        </section>
    </div>
    <div class="row">
        <section class="col col-6">
            {!! Form::label('description', trans($admin_trans_path.'general.columns.description')) !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </section>
    </div>
</fieldset>