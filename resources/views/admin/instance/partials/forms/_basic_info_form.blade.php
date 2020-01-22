<div class="smart-form">
    <fieldset>
        <section class="form-group">
            <label class="label">{{ trans($trans_path.'general.basic-info.project-name') }}</label>
            <label class="input">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.basic-info.project-name'), 'required']) !!}
            </label>
        </section>
        @php
            $selectedFacilityId = auth()->user()->id;
            if (isset($data['instance']) && $data['instance']->siteDelivery)
                $selectedFacilityId = $data['instance']->siteDelivery->facility_user_id;
        @endphp
        <div style="display: none;">
            <input type="hidden" name="facility_user" value="{{$selectedFacilityId}}">
        </div>
        {{--<section class="form-group">--}}
            {{--<label class="label">{{ trans($trans_path.'general.basic-info.facility-user') }}</label>--}}
            {{--<label class="input">--}}
                {{--<select class="form-control select2" name="facility_user" required>--}}
                    {{--@foreach($data['facility_users'] as $facilityUser)--}}
                        {{--<option value="{{ $facilityUser->id }}" {{ ($selectedFacilityId == $facilityUser->id) ? 'selected' : null }}>{{ $facilityUser->first_name . ' ' . $facilityUser->last_name }}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</label>--}}
        {{--</section>--}}

        {{--<section class="form-group">--}}
            {{--<label class="label">{{ trans($trans_path.'general.basic-info.facility') }}</label>--}}
            {{--<label class="input">--}}
                {{--<select class="form-control" name="facility" required>--}}
                    {{--@if (isset($data['instance']) && $siteDelivery = $data['instance']->siteDelivery)--}}
                        {{--<option value="{{ $siteDelivery->facility_id }}">{{ $siteDelivery->facility_name }}</option>--}}
                    {{--@endif--}}
                {{--</select>--}}
            {{--</label>--}}
        {{--</section>--}}

        <div class="row" style="">

            <section class="form-group col col-3 selectEditablePR">
                <label class="label">{{ trans($trans_path.'general.columns.province_name') }}</label>
                <label class="select">
                    {!! Form::select('province_name', $province , (isset($data['instance']) && $data['instance']->siteDelivery) ? $data['instance']->siteDelivery->province_name : (isset($data['user']) ? $data['user']->province : null), ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.province_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>

            <section class="form-group col col-3 inputEditablePR">
                <label class="label">{{ trans($trans_path.'general.columns.province_name') }}</label>
                <label class="input">
                    {!! Form::text('province', (isset($data['instance']) && $data['instance']->siteDelivery) ? $data['instance']->siteDelivery->province_name : (isset($data['user']) ? $data['user']->province : null), ['class' => 'form-control disabled', 'placeholder'=>trans($trans_path.'general.columns.province_name'), 'required', 'disabled']) !!}
                </label>
            </section>
            <section class="form-group col col-3 selectEditableDD">
                <label class="label">{{ trans($trans_path.'general.columns.district_name') }}</label>
                <label class="select">
                    {!! Form::select('district_name', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.district_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>
            <section class="form-group col col-3 inputEditableDD">
                <label class="label">{{ trans($trans_path.'general.columns.district_name') }}</label>
                <label class="input">
                    {!! Form::text('district', null, ['class' => 'form-control disabled', 'placeholder'=>trans($trans_path.'general.columns.district_name'), 'required', 'disabled']) !!}
                </label>
            </section>
            <section class="form-group col col-3 selectEditablePA">
                <label class="label">{{ trans($trans_path.'general.columns.palika_name') }}</label>
                <label class="select">
                    {!! Form::select('palika_name', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.palika_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>
            <section class="form-group col col-3 inputEditablePA">
                <label class="label">{{ trans($trans_path.'general.columns.palika_name') }}</label>
                <label class="input">
                    {!! Form::text('palika', null, ['class' => 'form-control disabled', 'placeholder'=>trans($trans_path.'general.columns.palika_name'), 'required', 'disabled']) !!}
                </label>
            </section>
            <section class="form-group col col-3 inputEditableHF">
                <label class="label">{{ trans($trans_path.'general.columns.hf_name') }}</label>
                <label class="input">
                    {!! Form::text('hf_name_new', null, ['class' => 'form-control disabled', 'placeholder'=>trans($trans_path.'general.columns.hf_name'), 'required', 'disabled']) !!}
                </label>
            </section>

            <section class="form-group col col-3 selectEditableHF">
                <label class="label">{{ trans($trans_path.'general.columns.hf_name') }}</label>
                <label class="select">
                    {!! Form::select('hf_name', [], null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.hf_name'), 'required']) !!}
                    <i></i>
                </label>
            </section>

        </div>


        <div class="row evaluationTeamData">
            <div class="col col-sm-12">
                <div class="alert alert-danger requiredEvaluationTeam" style="display: none;">
                    <i class="fa fa-remove fa-fw"></i> {{ trans($trans_path . 'general.error.one-evaluation-team') }}
                </div>
                <h3>
                    {{ trans($trans_path.'general.basic-info.selected-evaluation-team') }}
                    <div class="pull-right">
                        <a href="#" class="btn btn-primary showEvaluationFomDiv"><i class="fa fa-fw fa-plus"></i> Show add form</a>
                        <a href="#" class="btn btn-danger hideEvaluationFomDiv" style="display: none;"><i class="fa fa-fw fa-remove"></i> Hide add form</a>
                    </div>
                </h3>
                <table class="table table-condensed table-striped" style="margin-top: 15px;">
                    <thead>
                        <tr>
                            <th>{{ trans($trans_path.'general.columns.sn') }}</th>
                            <th>{{ trans($trans_path.'general.basic-info.team-name') }}</th>
                            <th>{{ trans($trans_path.'general.basic-info.team-title') }}</th>
                            <th>{{ trans($trans_path.'general.basic-info.organization') }}</th>
                            <th>{{ trans($trans_path.'general.basic-info.team-email') }}</th>
                            <th>{{ trans($trans_path.'general.basic-info.team-telephone') }}</th>
                            <th>{{ trans($trans_path.'general.columns.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data['evaluationTeam']))
                            @php $evaluationCounter = 0; @endphp
                            @foreach($data['evaluationTeam'] as $evaluation)
                                <tr>
                                    <td>{{++$evaluationCounter}}</td>
                                    <td>{{ isset($evaluation['name']) ? $evaluation['name'] : null }}<input name="team-name[]" value="{{ isset($evaluation['name']) ? $evaluation['name'] : null }}" class="team-name" type="hidden"></td>
                                    <td>{{ isset($evaluation['title']) ? $evaluation['title'] : null }}<input name="team-title[]" value="{{ isset($evaluation['title']) ? $evaluation['title'] : null }}" class="team-title" type="hidden"></td>
                                    <td>{{ isset($evaluation['organization']) ? $evaluation['organization'] : null }}<input name="team-organization[]" value="{{ isset($evaluation['organization']) ? $evaluation['organization'] : null }}" class="team-organization" type="hidden"></td>
                                    <td>{{ isset($evaluation['email']) ? $evaluation['email'] : null }}<input name="team-email[]" value="{{ isset($evaluation['email']) ? $evaluation['email'] : null }}" class="team-email" type="hidden"></td>
                                    <td>{{ isset($evaluation['telephone']) ? $evaluation['telephone'] : null }}<input name="team-telephone[]" value="{{ isset($evaluation['telephone']) ? $evaluation['telephone'] : null }}" class="team-telephone" type="hidden"></td>
                                    <td>
                                        <input name="team_id[]" value="" class="team_id" type="hidden">
                                        <a href="javascript:void(0)" class="text-info edit">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="text-danger remove">
                                            <i class="fa fa-fw fa-remove"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </fieldset>
    <div class="well row evaluationTeamAddForm" style="margin: 10px; padding-bottom: 10px; display: none;">
        <header>{{ trans($trans_path.'general.basic-info.evaluation-team-form') }}</header>
        <fieldset>
            <section class="col col-sm-12">
                <label class="label">{{ trans($trans_path.'general.basic-info.team-name') }}</label>
                <label class="input">
                    <input type="text" id="team-name" class="form-control" placeholder="{{ trans($trans_path.'general.basic-info.team-name') }}" />
                    <span class="errorSpan text-danger" style="display: none;">This field is required</span>
                </label>
            </section>

            <div class="">
                <section class="col col-sm-12 col-md-6">
                    <label class="label">{{ trans($trans_path.'general.basic-info.team-title') }}</label>
                    <label class="input">
                        <input type="text" id="team-title" class="form-control" placeholder="{{ trans($trans_path.'general.basic-info.team-title') }}" />
                    </label>
                </section>
                <section class="col col-sm-12 col-md-6">
                    <label class="label">{{ trans($trans_path.'general.basic-info.organization') }}</label>
                    <label class="input">
                        <input type="text" id="team-organization" class="form-control" placeholder="{{ trans($trans_path.'general.basic-info.organization') }}" />
                    </label>
                </section>
            </div>

            <section class="col col-sm-12 col-md-6">
                <label class="label">{{ trans($trans_path.'general.basic-info.team-email') }}</label>
                <label class="input">
                    <input type="text" id="team-email" class="form-control" placeholder="{{ trans($trans_path.'general.basic-info.team-email') }}" />
                </label>
                <span class="text-danger" id="team-email-error" style="display: none;">Invalid email address</span>
            </section>

            <section class="col col-sm-12 col-md-6">
                <label class="label">{{ trans($trans_path.'general.basic-info.team-telephone') }}</label>
                <label class="input">
                    <input type="text" id="team-telephone" class="form-control" placeholder="{{ trans($trans_path.'general.basic-info.team-telephone') }}" />
                </label>
            </section>


            <div class="col col-sm-12 text-right">
                <a href="javascript:void(0)" class="btn btn-danger cancelEvaluationTeam">
                    <i class="fa fa-remove fa-fw"></i> Cancel
                </a>
                <a href="javascript:void(0)" class="btn btn-primary addEvaluationTeam">
                    <i class="fa fa-plus fa-fw"></i> Add
                </a>
                <a href="javascript:void(0)" class="btn btn-primary updateEvaluationTeam" style="display: none;">
                    <i class="fa fa-edit fa-fw"></i> Update
                </a>
            </div>
        </fieldset>
    </div>
</div>