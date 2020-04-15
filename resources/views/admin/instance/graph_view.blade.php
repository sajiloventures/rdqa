@extends('layouts.' . $data['page_layout'])
@section('page_title', trans($trans_path.'general.page.graph.title'))
@section('page_description', trans($trans_path.'general.page.graph.page-title'))
@section('page_specific_styles')
    <style>
        .jarviswidget .widget-body {
            padding-top: 30px;
        }
        .selectEditable {
            padding-left: 0;
        }
    </style>
@endsection
@section('content')

    <!-- MAIN CONTENT -->
    <div id="content">
        @include('admin.partials._status')

        <div class="row">
            @if($data['display_search'])
                <div class="col-sm-12">
                    <section id="widget-grid" class="">

                        <!-- row -->
                        <div class="row">
                            @include($view_path . '.partials.graph.search_bar')
                        </div>
                        <!-- end row -->
                    </section>
                    <!-- end widget grid -->
                </div>
            @endif
            <div class="col-sm-12">

                <!-- widget grid -->
                <section id="widget-grid" class="">

                    <!-- row -->
                    <div class="row">
                        @if(!$data['instances'] || count($data['instances']) < 1)
                            @if($data['page_layout'] == 'admin' && $data['search_request'] == false)
                                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-5 createInstanceDiv">

                                    <div class="widget-body well text-center" style="width: 70%; margin: auto;">
                                        <span class="text-primary">{{ trans('general.common.dear') }} {{ auth()->user()->fullName }}</span>
                                        <h1 style="margin-bottom: 5px;">
                                            {{ trans('general.common.welcome') }} <br />
                                            <small>{{ trans('general.common.to-start') }}</small>
                                        </h1>

                                        <a href="{{ route('admin.instance.create') }}" class="btn btn-primary btn-lg" ><i class="fa fa-plus"></i> {{ trans('general.button.create-instance') }}</a>
                                    </div>

                                </article>
                                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="widget-body well no-padding text-center videoDiv" style="width: 70%; margin: auto;">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="https://drive.google.com/file/d/1zzigKKnfn4ExU3YPSziL2LukDVAgIwoi/preview"></iframe>
                                        </div>
                                    </div>

                                    <p class="text-right" style="width: 85%; margin-top: 10px;">
                                        <a href="javascript:void(0)" class="btn btn-primary makeFullScreen"><i class="fa fa-arrows-alt"></i> Full screen</a>
                                    </p>
                                    <p class="text-right" style="width: 100%; margin-top: 10px; display: none;">
                                        <a href="javascript:void(0)" class="btn btn-primary makeSmallScreen"><i class="fa fa-arrows-alt"></i> Small screen</a>
                                    </p>
                                </article>
                            @endif
                            <div class="text-div">
                            </div>
                        @else

                            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                @include($view_path . 'partials.graph.countbar')

                                <div class="widget-body">

                                    <ul id="myTab1" class="nav nav-tabs bordered">
                                        @if($data['page_layout'] == 'admin')
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
                                            @if(isset($data['instance']))
                                                <li>
                                                    <a href="#evaluation-team" data-toggle="tab">
                                                        <i class="fa fa-fw fa-lg fa-users"></i> Evaluation Team
                                                    </a>
                                                </li>
                                            @endif
                                        @endif

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

                                        @if($data['page_layout'] == 'admin')
                                            <div class="tab-pane fade" id="system-assestment">
                                                @include($view_path . '.partials.graph.system_assessment')
                                            </div>

                                            <div class="tab-pane fade" id="action-plan">
                                                @include($view_path . '.partials.graph.action_plan')
                                            </div>
                                            @if(isset($data['instance']))
                                                <div class="tab-pane fade" id="evaluation-team">
                                                    @include($view_path . '.partials.graph.evaluation_team')
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                </div>

                            </article>
                        @endif

                    </div>

                    <!-- end row -->


                </section>
                <!-- end widget grid -->

            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('page_specific_scripts')

    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="{{ asset('smartadmin/js/plugin/moment/moment.min.js') }}"></script>
{{--    <script src="{{ asset('smartadmin/js/plugin/chartjs/chart.min.js') }}"></script>--}}
    <script src="{{ asset('chart_js/chart.js') }}"></script>

    @if(count($data['instances']) > 0)
        @include($view_path . '.partials.graph.script')
    @endif

    <script>
        $('.makeFullScreen').on('click', function (e) {
            e.preventDefault();
            $('.createInstanceDiv').slideUp();
            $('.videoDiv').css('width', '100%');
            $(this).closest('p').hide();
            $('.makeSmallScreen').closest('p').show();
        });
        $('.makeSmallScreen').on('click', function (e) {
            e.preventDefault();
            $('.createInstanceDiv').slideDown();
            $('.videoDiv').css('width', '70%');
            $(this).closest('p').hide();
            $('.makeFullScreen').closest('p').show();
        });

        // Date Range Picker
        $("#from_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onClose: function (selectedDate) {
                $("#to_date").datepicker("option", "minDate", selectedDate);
            }

        });
        $("#to_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onClose: function (selectedDate) {
                $("#from_date").datepicker("option", "maxDate", selectedDate);
            }
        });
    </script>

    @php
        $provinceName = isset($_REQUEST['province_name']) ? $_REQUEST['province_name'] : "";
        $districtName = isset($_REQUEST['district_name']) ? $_REQUEST['district_name'] : "";
        $palikaName = isset($_REQUEST['palika_name']) ? $_REQUEST['palika_name'] : "";
        $hfName = isset($_REQUEST['hf_name']) ? $_REQUEST['hf_name'] : "";
    @endphp

    <script>

        $('#search_bar_form').on('change', 'select[name="province_name"]', function () {
            $('input[name="province"]').val($(this).val());

            $('select[name="palika_name"]').html('<option value=""></option>');
            $('select[name="district_name"]').html('<option value=""></option>');
            $('select[name="hf_name"]').html('<option value=""></option>');
            getProvinceDistrictData($('select[name="district_name"]'), 'district_name', $(this).val());
        });
        $('#search_bar_form').on('change', 'select[name="district_name"]', function () {
            $('input[name="district"]').val($(this).val());

            $('select[name="palika_name"]').html('<option value=""></option>');
            $('select[name="hf_name"]').html('<option value=""></option>');
            getProvinceDistrictData($('select[name="palika_name"]'), 'palika_name', $(this).val());
        });
        $('#search_bar_form').on('change', 'select[name="palika_name"]', function () {
            $('input[name="palika"]').val($(this).val());

            $('select[name="hf_name"]').html('<option value=""></option>');
            $('select[name="hf_name"]').html('<option value=""></option>');
            getProvinceDistrictData($('select[name="hf_name"]'), 'health_post_name', $(this).val());
        });
        $('#search_bar_form').on('change', 'select[name="hf_name"]', function () {
            $('input[name="hf_name_new"]').val($(this).val());
        });

        function getProvinceDistrictData($this, type, id, selected) {
            if (!selected)
                selected = "";

            if (type === 'district_name')
                $('input[name="province"]').val(id);
            if (type === 'palika_name')
                $('input[name="district"]').val(id);
            if (type === 'health_post_name')
                $('input[name="palika"]').val(id);


            $.get('{{ route('get-facility') }}?type=' + type + '&id=' + id, function (response) {
                var options = '<option value=""></option>';
                if (response) {
                    $.each(response, function (key, value) {
                        key = value;
                        if(key === selected)
                            options += '<option value="' + key + '" selected="selected">' + value + '</option>';
                        else
                            options += '<option value="' + key + '">' + value + '</option>';

                    });
                    $this.html(options);
                }
            }).fail(function (response) {
                alert('error while getting data');
            });
        }

        $(document).ready(function () {
            $('.selectEditable, .selectEditableHF').show();
            $('.inputEditable, .inputEditableHF').hide();
            $('.selectEditable').closest('.row').show();

            @if ($provinceName)
                getProvinceDistrictData($('select[name="district_name"]'), 'district_name', "{{ $provinceName }}", "{{ $districtName }}");
            @endif
            @if ($districtName)
                getProvinceDistrictData($('select[name="palika_name"]'), 'palika_name', "{{ $districtName }}", "{{ $palikaName }}");
            @endif
            @if ($palikaName)
                getProvinceDistrictData($('select[name="hf_name"]'), 'health_post_name', "{{ $palikaName }}", "{{ $hfName }}");
            @endif
        });

    </script>
 

<script>
var ctx = document.getElementById('dataCountBarChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
   // type: 'horizontalBar',

    data: {
        labels: [
         @foreach($data['delivery_data'] as $key=> $value)
         @if($loop->last)
       
    '{{ str_replace(" ", "\\n", $key)}}'
    @else 
        '{{ str_replace(" ", "\\n", $key)}}',
    @endif

@endforeach
        ],
        fill: true,
        datasets: [{
           label: '# of Instances',
         
            data: [  @foreach($data['delivery_data'] as $key=> $value)
         @if($loop->last)
    '{{ $value}}'
    @else 
        '{{ $value}}',
    @endif

@endforeach],
            backgroundColor:

                'rgb(51, 125, 165)',
            borderColor: 
                 
                'rgb(51, 125, 165)',
            borderWidth: 1
        }]
    },

     options: {
           responsive: true,
          
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
          /*       ticks: {
                callback: function(value) {
                    return value.substr(0, 15);
     tooltips: {
                    enabled: true
                },
            },*/
                // Change here
                barPercentage: 0.2
                //maxBarThickness: 100,
            }]
        },
     tooltips: {
                    enabled: true
                },
                hover: {
                    animationDuration: 1
                },
                animation: {
                    duration: 1,
                    onComplete: function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "rgba(0, 0, 0, 1)";
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);

                            });
                        });
                    }
                }
    }
});
</script>
<script>

    function request_access($this){
        //console.log("button clicked");
        var request_data = $this.id;
        console.log("data: " + request_data)
        $.post( "{{ url('/') }}/request_access",{ request_data: request_data})
        .done(function(data) {
            var val = data.value;
            if(data.value == 1){
                 $($this).prev('i').removeClass().addClass('fa fa-check text-success');
            }
            else {
                $($this).prev('i').removeClass().addClass('fa fa-remove text-danger');
            }
          //alert("Data Loaded: " + data.value);
          //Or return data;
        });
    }
</script>
@endsection