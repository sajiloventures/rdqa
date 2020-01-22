<div class="col-md-9">
    <div class="fill-form">
        <div class="card-block">
            <div class="card">
                <div class="card-block">
                     <div class="form-design1">
                        <div class="form-group">
                            <label for="name">
                                {!! Form::label('option_name', trans($trans_path . 'general.columns.key')) !!}
                            </label>
                            <div class="input-group cstm-addon">
                                <div class="input-group-addon">
                                    <i class="fa fa-cog"></i>
                                </div>
                                <?php if(isset($config) && !$config->isEditableBy()): ?>
                                {!! Form::text('option_name', ViewHelper::getFormValue('option_name', isset($configure['option_name'])?$configure['option_name']:''), ['class' => 'form-control', 'disabled'=>'disabled', 'placeholder'=>trans($trans_path . 'general.columns.key')]) !!}
                                <?php else: ?>
                                {!! Form::text('option_name', ViewHelper::getFormValue('option_name', isset($configure['option_name'])?$configure['option_name']:''), ['class' => 'form-control', 'placeholder'=>trans($trans_path . 'general.columns.key')]) !!}
                                <?php endif; ?>
                            </div>
                            @if($errors->has('option_name'))
                                <small class="text-danger">{!! $errors->first('option_name') !!}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">
                                {!! Form::label('option_value', trans($trans_path . 'general.columns.value')) !!}
                            </label>
                                {!! Form::textarea('option_value', ViewHelper::getFormValue('name', isset($configure['option_value'])?$configure['option_value']:''), ['class' => 'form-control', 'rows' => 3, 'placeholder'=>trans($trans_path . 'general.columns.value')]) !!}
                            <small class="text-muted">
                                <strong>Note:</strong> {{ trans($trans_path . 'general.action.note') }}
                            </small>
                           @if($errors->has('option_value'))
                                <small class="text-danger">{!! $errors->first('option_value') !!}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="country">
                                {!! Form::label('remarks', trans($trans_path . 'general.columns.remarks')) !!}
                            </label>
                                {!! Form::textarea('remarks', ViewHelper::getFormValue('name', isset($configure['remarks'])?$configure['remarks']:''), ['class' => 'form-control', 'rows' => 3, 'placeholder'=>trans($trans_path . 'general.columns.remarks')]) !!}
                            <small class="text-muted">
                                <strong>Note:</strong> {{ trans($trans_path . 'general.action.remarks') }}
                            </small>
                           @if($errors->has('remarks'))
                                <small class="text-danger">{!! $errors->first('remarks') !!}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
