<div class="smart-form">
    <fieldset>
        <div class="row">
            <section class="col col-5">
                <label class="label">{{ trans($trans_path.'general.columns.compare_name_1') }}</label>
                <label class="input">
                    <i class="icon-prepend fa fa-arrow-right">
                    </i>
                    {!! Form::text('compare_name_1', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.compare_name_1')]) !!}
                </label>
            </section>
            <section class="col col-1 text-center">
                <strong style="position: absolute;margin-top: 30px;">VS</strong>
            </section>
            <section class="col col-6">
                <label class="label">{{ trans($trans_path.'general.columns.compare_name_2') }}</label>
                <label class="input">
                    <i class="icon-prepend fa fa-arrow-right">
                    </i>
                    {!! Form::text('compare_name_2', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.compare_name_2')]) !!}
                </label>
            </section>

        </div>

        <section>
            <label class="label">{{ trans($trans_path.'general.columns.description') }}</label>
            <label class="input">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.description')]) !!}
            </label>
        </section>

        <section>
            <label class="label">{{ trans($admin_trans_path.'general.columns.status') }}</label>
            <div class="checkbox">
                <label>
                    <input name="status" type="checkbox" class="checkbox" value="1" {{ isset($compare_sheet) && $compare_sheet->status == 1 ? 'checked' : null }} />
                    <span>{{ trans($admin_trans_path.'general.columns.status') }} </span>
                </label>
            </div>
        </section>
    </fieldset>
</div>