<div class="smart-form">
    <fieldset>
        <section>
            <label class="label">{{ trans($trans_path.'general.columns.program') }}</label>
            <label class="input">
                <i class="icon-prepend fa fa-arrow-right">
                </i>
                {!! Form::text('program', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.program')]) !!}
            </label>
        </section>

        <section>
            <label class="label">{{ trans($admin_trans_path.'general.columns.name') }}</label>
            <label class="input">
                <i class="icon-prepend fa fa-arrow-right">
                </i>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>trans($admin_trans_path.'general.columns.name')]) !!}
            </label>
        </section>

        <section>
            <label class="label">{{ trans($admin_trans_path.'general.columns.status') }}</label>
            <div class="checkbox">
                <label>
                    <input name="status" type="checkbox" class="checkbox" value="1" {{ isset($indicator) && $indicator->status == 1 ? 'checked' : null }} />
                    <span>{{ trans($admin_trans_path.'general.columns.status') }} </span>
                </label>
            </div>
        </section>
    </fieldset>
</div>