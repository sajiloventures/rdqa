<div class="smart-form">
    <fieldset>
        <div class="row">
            <div class="col col-sm-12 indicatorData">
                <div class="alert alert-danger requiredIndicator" style="display: none;">
                    <i class="fa fa-remove fa-fw"></i> {{ trans($trans_path . 'general.error.four-indicator') }}
                </div>
                <h3>
                    {{ trans($trans_path.'general.indicator.selected-indicator') }}
                    <div class="pull-right">
                        <a href="#" class="btn btn-primary showIndicatorFormDiv"><i class="fa fa-fw fa-plus"></i> Show add form</a>
                        <a href="#" class="btn btn-danger hideIndicatorFormDiv" style="display: none;"><i class="fa fa-fw fa-remove"></i> Hide add form</a>
                    </div>
                </h3>
                <table class="table table-condensed table-striped" style="margin-top: 15px;">
                    <thead>
                        <tr>
                            <td>{{ trans($trans_path.'general.columns.sn') }}</td>
                            <td>{{ trans($trans_path.'general.columns.indicator') }}</td>
                            <td>{{ trans($trans_path.'general.columns.cross-check-1') }}</td>
                            <td>{{ trans($trans_path.'general.columns.cross-check-2') }}</td>
                            <td>{{ trans($trans_path.'general.columns.cross-check-3') }}</td>
                            <td>{{ trans($trans_path.'general.columns.date') }}</td>
                            <td>{{ trans($trans_path.'general.columns.action') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data['instance']) && $data['instance']->indicators)
                            @php $indicatorCounter = 0; @endphp
                            @foreach($data['instance']->indicators as $selectedIndicator)
                                <tr>
                                    <td>{{++$indicatorCounter}}</td>
                                    <td>
                                        <span>{{$selectedIndicator->indicator ? $selectedIndicator->indicator->name : null }}</span>
                                        <input name="indicator[]" value="{{ $selectedIndicator->indicator_id }}" class="indicator" type="hidden">
                                        <input name="program[]" value="{{ $selectedIndicator->indicator ? $selectedIndicator->indicator->program : null }}" class="program" type="hidden">
                                    </td>
                                    @php
                                        $selectedCrossCheck = null;
                                        if($selectedIndicator->indicatorCrossCheck)
                                            $selectedCrossCheck = $selectedIndicator->indicatorCrossCheck;

                                    @endphp
                                    <td>
                                        {{$selectedCrossCheck && isset($data['compareSheetsArray'][$selectedCrossCheck->cross_check_1_a_id]) ? $data['compareSheetsArray'][$selectedCrossCheck->cross_check_1_a_id] : null}}
                                        {{ $selectedCrossCheck && isset($data['compareSheetsArray'][$selectedCrossCheck->cross_check_1_b_id]) ? ' vs ' . $data['compareSheetsArray'][$selectedCrossCheck->cross_check_1_b_id] : null}}
                                        <input name="cross_check_1_a[]" value="{{$selectedCrossCheck ? $selectedCrossCheck->cross_check_1_a_id : null}}" class="cross_check_1_a" type="hidden">
                                    </td>
                                    <td>
                                        {{$selectedCrossCheck && isset($data['compareSheetsArray'][$selectedCrossCheck->cross_check_2_a_id]) ? $data['compareSheetsArray'][$selectedCrossCheck->cross_check_2_a_id] : null}}
                                        {{ $selectedCrossCheck && isset($data['compareSheetsArray'][$selectedCrossCheck->cross_check_2_b_id]) ? ' vs ' . $data['compareSheetsArray'][$selectedCrossCheck->cross_check_2_b_id] : null}}
                                        <input name="cross_check_2_a[]" value="{{$selectedCrossCheck ? $selectedCrossCheck->cross_check_2_a_id : null}}" class="cross_check_2_a" type="hidden">
                                    </td>
                                    <td>
                                        {{$selectedCrossCheck && isset($data['compareSheetsArray'][$selectedCrossCheck->cross_check_3_a_id]) ? $data['compareSheetsArray'][$selectedCrossCheck->cross_check_3_a_id] : null}}
                                        {{ $selectedCrossCheck && isset($data['compareSheetsArray'][$selectedCrossCheck->cross_check_3_b_id]) ? ' vs ' . $data['compareSheetsArray'][$selectedCrossCheck->cross_check_3_b_id] : null}}
                                        <input name="cross_check_3_a[]" value="{{$selectedCrossCheck ? $selectedCrossCheck->cross_check_3_a_id : null}}" class="cross_check_3_a" type="hidden">
                                    </td>
                                    <td>
                                        {{date('Y-m-d', strtotime($selectedIndicator->from_date))}} - {{date('Y-m-d', strtotime($selectedIndicator->to_date))}}
                                        <input name="from_date[]" value="{{$selectedIndicator->from_date}}" class="from_date" type="hidden">
                                        <input name="to_date[]" value="{{$selectedIndicator->to_date}}" class="to_date" type="hidden">
                                        <input name="from_date_eng[]" value="{{$selectedIndicator->from_date_eng}}" class="from_date_eng" type="hidden">
                                        <input name="to_date_eng[]" value="{{$selectedIndicator->to_date_eng}}" class="to_date_eng" type="hidden">
                                    </td>
                                    <td>
                                        <input name="instance_indicator_id[]" value="{{ $selectedIndicator->id }}" class="indicator_id" type="hidden">
                                        <a href="javascript:void(0)" class="text-info edit"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="text-danger remove"><i class="fa fa-fw fa-remove"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </fieldset>
    <div class="well row indicatorForm" style="margin: 10px; padding-bottom: 10px; display: none;">
        <header>{{ trans($trans_path.'general.indicator.indicator-form') }}</header>
        <fieldset>
            <section class="col col-6 form-group">
                <label class="control-label">{{ trans($trans_path.'general.columns.program') }}</label>
                <label class="input">
                    <select class="form-control select2 indicator_program" name="indicator_program" id="indicator_program">
                        <option value="">{{trans($trans_path.'general.columns.select-program')}}</option>
                        @foreach($data['indicator-programs'] as $program)
                            <option value="{{ $program->program }}">{{ $program->program }}</option>
                        @endforeach
                    </select>
                    <span class="errorSpan text-danger" style="display: none;">This field is required</span>
                </label>
            </section>
            <section class="col col-6 form-group">
                <label class="control-label">{{ trans($trans_path.'general.columns.indicator') }}</label>
                <label class="input">
                    <select class="form-control indicator_indicator" name="indicator_indicator" id="indicator_indicator">
                        {{--@foreach($data['indicators'] as $indicator)--}}
                            {{--<option value="{{ $indicator->id }}">{{ $indicator->program . '-> ' . $indicator->name }}</option>--}}
                        {{--@endforeach--}}
                    </select>
                    <span class="errorSpan text-danger" style="display: none;">This field is required</span>
                    <span class="error2Span text-danger" style="display: none;">Indicator already been used. Please select different one.</span>
                </label>
            </section>

            <section class="col col-sm-12 form-group">
                <label class="control-label">{{ trans($trans_path.'general.columns.cross-check-1') }}</label>
                <label class="select">
                    <select class="form-control" name="indicator_cross_check_1_a" id="indicator_cross_check_1_a">
                        <option value="">{{ trans($trans_path.'general.indicator.select-compare-sheet') }}</option>
                        @foreach($data['compareSheets'] as $compareSheet)
                            <option value="{{ $compareSheet->id }}">{{ $compareSheet->name . ($compareSheet->name_2 ? ' vs ' . $compareSheet->name_2 : null) }}</option>
                        @endforeach
                    </select>
                    <i></i>
                    <span class="errorSpan text-danger" style="display: none;">This field is required</span>
                </label>
            </section>
            <section class="col col-sm-12 form-group">
                <label class="control-label">{{ trans($trans_path.'general.columns.cross-check-2') }}</label>
                <label class="select">
                    <select class="form-control" name="indicator_cross_check_2_a" id="indicator_cross_check_2_a">
                        <option value="">{{ trans($trans_path.'general.indicator.select-compare-sheet') }}</option>
                        @foreach($data['compareSheets'] as $compareSheet)
                            <option value="{{ $compareSheet->id }}">{{ $compareSheet->name . ($compareSheet->name_2 ? ' vs ' . $compareSheet->name_2 : null) }}</option>
                        @endforeach
                    </select>
                    <i></i>
                    <span class="errorSpan text-danger" style="display: none;">This field is required</span>
                </label>
            </section>
            <section class="col col-sm-12">
                <label class="control-label">{{ trans($trans_path.'general.columns.cross-check-3') }}</label>
                <label class="select">

                    <select class="form-control" name="indicator_cross_check_3_a" id="indicator_cross_check_3_a">
                        <option value="">{{ trans($trans_path.'general.indicator.select-compare-sheet') }}</option>
                        @foreach($data['compareSheets'] as $compareSheet)
                            <option value="{{ $compareSheet->id }}">{{ $compareSheet->name . ($compareSheet->name_2 ? ' vs ' . $compareSheet->name_2 : null) }}</option>
                        @endforeach
                    </select>
                    <i></i>
                </label>
            </section>
            <section class="col col-6 form-group">
                <label class="control-label">{{ trans($trans_path.'general.columns.from_date') }}</label>
                <label class="input-group">
                    {!! Form::text('indicator_from_date', null, ['class' => 'form-control date-picker', 'id' => 'indicator_from_date', 'placeholder'=>trans($trans_path.'general.columns.from_date')]) !!}
                    {!! Form::hidden('indicator_from_date_eng', null, ['id' => 'indicator_from_date_eng']) !!}
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </label>
                <span class="errorSpan text-danger" style="display: none;">This field is required</span>
            </section>
            <section class="col col-6 form-group">
                <label class="control-label">{{ trans($trans_path.'general.columns.to_date') }}</label>
                <label class="input-group">
                    {!! Form::text('indicator_to_date', null, ['class' => 'form-control date-picker', 'id' => 'indicator_to_date', 'placeholder'=>trans($trans_path.'general.columns.to_date')]) !!}
                    {!! Form::hidden('indicator_to_date_eng', null, ['id' => 'indicator_to_date_eng']) !!}
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </label>
                <span class="errorSpan text-danger" style="display: none;">This field is required</span>
            </section>
            <div class="col col-sm-12 text-right">
                <a href="javascript:void(0)" class="btn btn-danger cancelIndicator">
                    <i class="fa fa-remove fa-fw"></i> Cancel
                </a>
                <a href="javascript:void(0)" class="btn btn-primary addIndicator">
                    <i class="fa fa-plus fa-fw"></i> Add
                </a>
                <a href="javascript:void(0)" class="btn btn-primary updateIndicator" style="display: none;">
                    <i class="fa fa-edit fa-fw"></i> Update
                </a>
            </div>
        </fieldset>
    </div>
</div>