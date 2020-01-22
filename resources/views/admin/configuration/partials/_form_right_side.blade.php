<div class="col-md-3">
    <div class="card-block">
        <div class="form-design1">
            <p class="m-b-0">
                <label for="text">
                    {!! Form::label('option_name', trans($trans_path . 'general.columns.status')) !!}
                </label>
            </p>
            <div class="btn-group radioButton">
                <input name="status" type="checkbox" data-on-color="success" data-off-color="danger"
                        {{((isset($configure['status']) && $configure['status'] == 1)
                            || !isset($configure['status'])) ?'checked':''}}>
            </div>
        </div>
    </div>
</div>
