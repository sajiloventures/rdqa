<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 50px;">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false"
         data-widget-editbutton="false"
         data-widget-togglebutton="false"
         data-widget-deletebutton="false"
         data-widget-collapsed="false"
         data-widget-fullscreenbutton="false"
    >
        <!-- widget div-->
        <div>

            <!-- widget content -->
            <div class="widget-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="tab-graph">
                            <ul id="myTab1" class="nav nav-tabs bordered">
                                <li class="active">
                                    <a href="#graph" data-toggle="tab">
                                        <i class="fa fa-fw fa-lg fa-bar-chart-o"></i> Graph
                                    </a>
                                </li>
                                <li>
                                    <a href="#system-assestment" data-toggle="tab">
                                        <i class="fa fa-fw fa-lg fa-arrow-circle-right"></i> System Assessment
                                    </a>
                                </li>
                                <li>
                                    <a href="#action-plan" data-toggle="tab">
                                        <i class="fa fa-fw fa-lg fa-arrow-circle-right"></i> Action Plan
                                    </a>
                                </li>
                                <li>
                                    <a href="#evaluation-team" data-toggle="tab">
                                        <i class="fa fa-fw fa-lg fa-users"></i> Evaluation Team
                                    </a>
                                </li>

                                @if(isset($data['projects-name']))
                                    <li class="pull-right">
                                        <a href="javascript:void(0);">
                                            {!! join(', ', $data['projects-name']) !!}
                                        </a>
                                    </li>
                                @else
                                    @if (AclHelper::isRouteAccessable('admin.instance.create:GET'))
                                        <li class="pull-right">
                                            <a href="{{ route('admin.instance.create') }}" class="btn btn-primary" style="color: white;">
                                                <i class="fa fa-plus"></i> Create Instance
                                            </a>
                                        </li>

                                    @endif
                                @endif
                            </ul>

                            <hr class="simple">

                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="graph">
                                    <!-- Widget ID (For radar chart)-->
                                @include($view_path . '.partials.graph.radar')
                                <!-- end widget -->
                                    <!-- Widget ID (For bar chart)-->
                                @include($view_path . '.partials.graph.bar')
                                <!-- end widget -->
                                </div>
                                <div class="tab-pane fade" id="system-assestment">
                                    @include($view_path . '.partials.graph.system_assessment')
                                </div>

                                <div class="tab-pane fade" id="action-plan">
                                    @include($view_path . '.partials.graph.action_plan')
                                </div>

                                <div class="tab-pane fade" id="evaluation-team">
                                    @include($view_path . '.partials.graph.evaluation_team')
                                </div>
                            </div>

                    </div>
                    <div class="tab-pane" id="tab-plan">
                        <div class="row">
                            <div class="col-sm-12" style="padding: 5px 20px 0 20px;">

                                    <table class="table table-striped table-hovered table-bordered actionPlanTable">
                                        <thead>
                                        <tr>
                                            @foreach($data['questions']['part-3']['type'] as $type)
                                                <th>{{ $type['name'] }}</th>
                                            @endforeach
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $actionCount = 0; @endphp
                                        @foreach($data['actionPlans'] as $aPlan)
                                            <tr id="{{++$actionCount}}">
                                                <td>
                                                    <select name="questionId[]" class="form-control identifiedInput">
                                                        <option value="data-verification" {{ $aPlan->question_id == 'data-verification' ? 'selected' : null}}>Data Verification</option>
                                                        @foreach($data['system_assessment_data'] as $sAd)
                                                            <option value="{{ $sAd->id }}" {{ $aPlan->question_id == $sAd->id ? 'selected' : null}}>{{ $sAd->type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="plan_id[]" class="form-control" value="{{ $aPlan->id }}">
                                                    <input type="hidden" name="identified[]" class="form-control identifiedInput" value="{{ $aPlan->weakness }}">
                                                </td>
                                               
                                                <td>
                                                    <input type="text" name="description[]" class="form-control identifiedInput" value="{{ $aPlan->description }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="responsible[]" class="form-control identifiedInput" value="{{ $aPlan->responsible }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="timeLine[]" id="timeLine_{{$actionCount}}" class="form-control identifiedInput" value="{{ $aPlan->time_line }}">
                                                    <input type="hidden" name="timeLineEng[]" id="timeLineEng_{{$actionCount}}" class="form-control" value="{{ $aPlan->time_line_eng }}">
                                                </td>
                                                <td align="center"><a href="javascript:void(0)" class="text-danger remove"><i class="fa fa-fw fa-remove"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <p class="errorDiv" style="display: none;">
                                        <span class="alert alert-danger col-xs-12">At least 2 action plans are required.</span>
                                    </p>
                                    <p class="text-right">
                                        <a href="javascript:void(0)" class="btn btn-primary addPlanningRow"><i class="fa fa-fw fa-plus"></i> Add</a>
                                    </p>
                                    @if($data['instance']->built_stage == 'step-3')
                                        <section>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="competed-status" type="checkbox" class="checkbox" value="1" />
                                                    <span>{{ $data['instance']->siteDelivery->facility_name }} {{ trans($trans_path.'general.common.complete-all-data-entry') }} </span>
                                                </label>
                                            </div>
                                        </section>
                                    @else
                                        <p>
                                            <span class="alert alert-info col-xs-12"><i class="fa fa-lg fa-exclamation-triangle"></i> Please complete all previous parts to mark it as completed.</span>
                                        </p>
                                    @endif
                                    {{--<div class="form-actions">--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="col-sm-12">--}}
                                                {{--<button type="submit" class="btn btn-primary"> Save </button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                <div style="display: none;">
                                    <input type="hidden" name="redirectTo" value="{{ isset($data['redirectTo']) ? $data['redirectTo'] : null }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="pager wizard no-margin">
                                    <!--<li class="previous first disabled">
                                    <a href="javascript:void(0);" class="btn btn-lg btn-default"> First </a>
                                    </li>-->
                                    <li class="previous disabled">
                                        <a href="javascript:void(0);" class="btn btn-default" style="border-radius: 0;"> Previous </a>
                                    </li>
                                    <li class="next">
                                        <a href="javascript:void(0);" class="btn txt-color-darken"  style="border-radius: 0;"> Next </a>
                                    </li>
                                    <li class="pull-right save" style="display: none;">
                                        <button type="submit" class="btn btn-primary"> Save </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->