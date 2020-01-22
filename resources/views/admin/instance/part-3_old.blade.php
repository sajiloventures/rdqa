@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.create.title'))
@section('page_description', trans($trans_path.'general.page.create.description'))
@section('page_specific_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('nepali_datepicker/nepali.datepicker.v2.2.min.css') }}" />
    <style>
        .smart-form section {
            margin-bottom: 25px;
        }
        .widget-grid .btn {
            padding: 5px 10px 5px 5px;
        }
        @media screen and (max-width: 600px) {

            .jarviswidget .widget-body {
                overflow: scroll;
            }
        }
    </style>
@endsection

@section('content')

    <div id="content">
    @include('admin.partials._status')

        <section id="widget-grid" class="">
            <div class="row padding-bottom-10">
                <div class="col-md-12 text-right">
                    <a href="javascript:void(0)" onclick="showHideGraphButton()" class="showHideButton btn btn-primary">Show graph</a>
                </div>
            </div>

            <!-- row -->
            <div class="row graphContainer" style="display: none;">

                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="widget-body">
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
                        </div>

                    </div>

                </article>

            </div>

            <!-- end row -->
        </section>

    <!-- widget grid -->
        <section class="" id="widget-grid">
            <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget jarviswidget-color-default"
                         data-widget-editbutton="false"
                         data-widget-colorbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         id="wid-id-0">
                        <header>
                            <h2>{{ strtoupper($data['questions']['part-3']['key']) }}: {{ $data['questions']['part-3']['name'] }}</h2>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 5px 20px 0 20px;">
                                        <form id="part3" method="post" action="{{ route('admin.instance.deliverySite.partThree.store', $data['instance']->id) }}" novalidate="novalidate">
                                            {!! csrf_field() !!}

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
                                                                <input type="hidden" name="plan_id[]" class="form-control" value="{{ $aPlan->id }}">
                                                                <input type="text" name="identified[]" class="form-control identifiedInput" value="{{ $aPlan->weakness }}">
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
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-primary"> Save </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="display: none;">
                                                <input type="hidden" name="redirectTo" value="{{ isset($data['redirectTo']) ? $data['redirectTo'] : null }}">
                                            </div>
                                        </form>
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

            </div>

            <!-- end row -->

            <!-- end row -->

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection
@section('page_specific_scripts')
    {!! Html::script('nepali_datepicker/nepali.datepicker.v2.2.min.js') !!}

    <script>

        $('.actionPlanTable tbody tr').each(function () {
            var id = $(this).attr('id');
            $(this).find('#timeLine_' + id).nepaliDatePicker({
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,
                ndpEnglishInput: ('timeLineEng_' + id)
            });
        });

        $('form').on('click', '.addPlanningRow', function (e) {
            e.preventDefault();
            var parent = $('.actionPlanTable tbody');
            var id = 0;
            if (parent.find('tr').length > 0)
                id = parent.find('tr:last-child').attr('id');

            var html = '<tr id="' + (++id) + '">\n' +
                '<td><input type="hidden" name="plan_id[]" class="form-control" />' +
                '<input type="text" name="identified[]" class="form-control identifiedInput" /></td>\n' +
                '<td><input type="text" name="description[]" class="form-control identifiedInput" /></td>\n' +
                '<td><input type="text" name="responsible[]" class="form-control identifiedInput" /></td>\n' +
                '<td><input type="text" id="timeLine_' + id + '" name="timeLineNep[]" class="form-control timeLine identifiedInput" />' +
                '<input type="hidden" id="timeLineEng_' + id + '" name="timeLine[]" class="form-control timeLineEng" /></td>\n' +
                '<td align="center"><a href="javascript:void(0)" class="text-danger remove"><i class="fa fa-fw fa-remove"></i></a></td>\n' +
                '</tr>';
            parent.append(html);
            parent.find('#timeLine_' + id).nepaliDatePicker({
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,
                ndpEnglishInput: ('timeLineEng_' + id)
            });
        });

        $('.actionPlanTable tbody').on('click', '.remove', function (e) {
            e.preventDefault();
            var title = 'Remove plan';
            var content = 'Are you sure want to remove this plan? <br />The process is irreversible.';
            removeAlert(title, content, $(this).closest('tr'));
        });

        function removeAlert(title, content, removeDiv) {
            $.SmartMessageBox({
                title : title,
                content : content,
                sound : false,
                buttons : '[No][Yes]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    removeDiv.remove();
                }

            });
        }

        $('#part3').on('submit', function () {
            $('.errorDiv').hide();
            $('.help-block.text-danger').remove();
            var hasError = true;
            $(this).find('.identifiedInput').each(function () {
               if (!$(this).val()) {
                   hasError = false;
                   $(this).closest('td').append('<span class="help-block text-danger">This field is required.</span>');
               }
           });

            if (!hasError)
                return false;

            if ($('.actionPlanTable tbody tr').length < 2) {
                $('.errorDiv').slideDown();
                return false;
            }


        });

    </script>


    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="{{ asset('smartadmin/js/plugin/moment/moment.min.js') }}"></script>
    {{--    <script src="{{ asset('smartadmin/js/plugin/chartjs/chart.min.js') }}"></script>--}}
    <script src="{{ asset('chart_js/chart.js') }}"></script>

    @include($view_path . '.partials.graph.script')
    <script>
        function showHideGraphButton() {
            var container = $('.graphContainer');
            var hideText = 'Hide Graph';
            var showText = 'Show Graph';
            if (container.is(':hidden')) {
                container.slideDown();
                $('.showHideButton').removeClass('btn-primary').addClass('btn-danger').html(hideText);
            } else {
                container.slideUp();
                $('.showHideButton').removeClass('btn-danger').addClass('btn-primary').html(showText);
            }
        }
    </script>
@endsection
