<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-5" id="search_bar_form">

    <form action="" method="get">
        <div class="widget-body well text-right">
            <div class="row">
                    <div class="col-sm-3 text-left">Filter</div>
                    <div class="col-sm-3">
                        <div class="form-group">
{{--                            {!! Form::select('compare_sheet', $data['compare_sheet'] , null, ['class' => 'form-control', 'placeholder'=>"Compare sheet"]) !!}--}}
                        </div>
                    </div>
                    <div class="col-sm-3">

                        <div class="form-group">
                            <div class="input-group">
                                @if(isset($data['disable_date_picker']) && $data['disable_date_picker']) 
                                {!! Form::text('from_date', $data['from_date'], ['class' => 'form-control',  'placeholder'=>'From', 'readonly']) !!}
                                @else
                                {!! Form::text('from_date', $data['from_date'], ['class' => 'form-control', 'id' => 'from_date', 'placeholder'=>'From']) !!}
                                @endif
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-3">

                        <div class="form-group">
                            <div class="input-group">
                                  @if(isset($data['disable_date_picker']) && $data['disable_date_picker']) 
                                {!! Form::text('to_date', $data['to_date'], ['class' => 'form-control', 'placeholder'=>'To','readonly']) !!}
                                @else
                                {!! Form::text('to_date', $data['to_date'], ['class' => 'form-control', 'id' => 'to_date', 'placeholder'=>'To']) !!}
                                @endif
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="row" style="display: none;">
                <div class="smart-form">
                    <fieldset style="padding: 10px 0;">
                        <section class="form-group col col-3 selectEditable">
                            <label class="label">{{ trans($trans_path.'general.columns.province_name') }}</label>
                            <label class="select">
                                {!! Form::select('province_name', $data['search_province'] , null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.province_name')]) !!}
                                <i></i>
                            </label>
                        </section>
                        <section class="form-group col col-3 selectEditable">
                            <label class="label">{{ trans($trans_path.'general.columns.district_name') }}</label>
                            <label class="select">
                                {!! Form::select('district_name', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.district_name')]) !!}
                                <i></i>
                            </label>
                        </section>
                        <section class="form-group col col-3 selectEditable">
                            <label class="label">{{ trans($trans_path.'general.columns.palika_name') }}</label>
                            <label class="select">
                                {!! Form::select('palika_name', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.palika_name')]) !!}
                                <i></i>
                            </label>
                        </section>

                        <section class="form-group col col-3 selectEditableHF">
                            <label class="label">{{ trans($trans_path.'general.columns.hf_name') }}</label>
                            <label class="select">
                                {!! Form::select('hf_name', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.hf_name')]) !!}
                                <i></i>
                            </label>
                        </section>
                    </fieldset>
                </div>
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-search"></i> Search</button>
                        <a href="{{ route('view-detail') }}" class="btn btn-danger">Clear</a>
                    </div>
                </div>

            </div>

            @if($data['search_request'])
                <div class="row text-left">
                    <div class="col-sm-12">
                        <small>
                            <strong>
                                Filtered variables: {!!  $data['search_request']  !!}
                            </strong>
                        </small>
                    </div>
                </div>
            @endif
        </div>

    </form>
</article>