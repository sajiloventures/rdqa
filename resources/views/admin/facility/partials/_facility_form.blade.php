<div class="smart-form">
    <fieldset>
        <div class="row">
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.province_code') }}</label>
                <label class="input">
                    {!! Form::text('province_code' , null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.province_code')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.province_name') }}</label>
                <label class="select">
                    {!! Form::select('province_name', $province , null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.province_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.district_code') }}</label>
                <label class="input">
                    {!! Form::text('district_code', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.district_code')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.district_name') }}</label>
                <label class="input">
                    {!! Form::text('district_name', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.district_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.palika_code') }}</label>
                <label class="input">
                    {!! Form::text('palika_code', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.palika_code')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.palika_name') }}</label>
                <label class="input">
                    {!! Form::text('palika_name', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.palika_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.ward_code') }}</label>
                <label class="input">
                    {!! Form::text('ward_code', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.ward_code')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.ward_name') }}</label>
                <label class="input">
                    {!! Form::text('ward_name', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.ward_name')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-4">
                <label class="control-label">{{ trans($trans_path.'general.columns.hf_code') }}</label>
                <label class="input">
                    {!! Form::text('hf_code', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.hf_code')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-4">
                <label class="control-label">{{ trans($trans_path.'general.columns.hf_type') }}</label>
                <label class="input">
                    {!! Form::text('hf_type', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.hf_type'), 'required']) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-4">
                <label class="control-label">{{ trans($trans_path.'general.columns.hf_name') }}</label>
                <label class="input">
                    {!! Form::text('hf_name', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.hf_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.urban_rural') }}</label>
                <label class="select">
                    {!! Form::select('urban_rural', ['RURAL' => 'RURAL', 'URBAN' => 'URBAN'], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.urban_rural')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.public_nonpublic') }}</label>
                <label class="select">
                    {!! Form::select('public_nonpublic', ['PUBLIC' => 'PUBLIC', 'NON PUBLIC' => 'NON PUBLIC'], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.public_nonpublic')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.ownership_type') }}</label>
                <label class="input">
                    {!! Form::text('ownership_type', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.ownership_type')]) !!}
                    <i></i>
                </label>
            </section>
            <section class="col col-6">
                <label class="control-label">{{ trans($trans_path.'general.columns.geography') }}</label>
                <label class="input">
                    {!! Form::text('geography', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.geography')]) !!}
                    <i></i>
                </label>
            </section>
        </div>

        <section>
            <label class="control-label">{{ trans($admin_trans_path.'general.columns.status') }}</label>
            <div class="checkbox">
                <label>
                    <input name="status" type="checkbox" class="checkbox" value="1" {{ isset($facility) && $facility->status == 1 ? 'checked' : null }} />
                    <span>{{ trans($admin_trans_path.'general.columns.status') }} </span>
                </label>
            </div>
        </section>
    </fieldset>
</div>