@extends('layouts.admin')
@section('content')
@section('page_title', trans($trans_path.'index.title'))
@section('page_description', trans($trans_path.'index.title'))
@section('content')

    <!-- MAIN CONTENT -->
    <div id="content">
        @include('admin.partials._status')

        <div class="row">
            <div class="col-sm-12">

                <!-- widget grid -->
                <section id="widget-grid" class="">

                    <!-- row -->
                    <div class="row">

                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0"
                                 data-widget-colorbutton="false"
                                 data-widget-editbutton="false"
                                 data-widget-deletebutton="false"
                                 data-widget-fullscreenbutton="false"
                                 data-widget-custombutton="false"
                                 data-widget-collapsed="false"
                                 data-widget-sortable="false">
                                <header>

                                    <h2>Line Chart </h2>

                                </header>

                                <!-- widget div-->
                                <div>

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->
                                        <input class="form-control" type="text">
                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body">

                                        <!-- this is what the user will see -->
                                        <canvas id="lineChart" height="120"></canvas>

                                    </div>
                                    <!-- end widget content -->

                                </div>
                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->

                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-1"
                                 data-widget-colorbutton="false"
                                 data-widget-editbutton="false"
                                 data-widget-deletebutton="false"
                                 data-widget-fullscreenbutton="false"
                                 data-widget-custombutton="false"
                                 data-widget-collapsed="false"
                                 data-widget-sortable="false">
                                <header>

                                    <h2>Radar Chart </h2>

                                </header>

                                <!-- widget div-->
                                <div>

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->
                                        <input class="form-control" type="text">
                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body">

                                        <!-- this is what the user will see -->
                                        <canvas id="radarChart" height="120"></canvas>

                                    </div>
                                    <!-- end widget content -->

                                </div>
                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->

                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-3"
                                 data-widget-colorbutton="false"
                                 data-widget-editbutton="false"
                                 data-widget-deletebutton="false"
                                 data-widget-fullscreenbutton="false"
                                 data-widget-custombutton="false"
                                 data-widget-collapsed="false"
                                 data-widget-sortable="false">
                                <header>

                                    <h2>Polar Chart </h2>

                                </header>

                                <!-- widget div-->
                                <div>

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->
                                        <input class="form-control" type="text">
                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body">

                                        <!-- this is what the user will see -->
                                        <canvas id="polarChart" height="120"></canvas>

                                    </div>
                                    <!-- end widget content -->

                                </div>
                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->

                        </article>
                        <!-- WIDGET END -->

                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-2"
                                 data-widget-colorbutton="false"
                                 data-widget-editbutton="false"
                                 data-widget-deletebutton="false"
                                 data-widget-fullscreenbutton="false"
                                 data-widget-custombutton="false"
                                 data-widget-collapsed="false"
                                 data-widget-sortable="false">
                                <header>

                                    <h2>Bar Chart </h2>

                                </header>

                                <!-- widget div-->
                                <div>

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->
                                        <input class="form-control" type="text">
                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body">

                                        <!-- this is what the user will see -->
                                        <canvas id="barChart" height="120"></canvas>

                                    </div>
                                    <!-- end widget content -->

                                </div>
                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->

                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-4"
                                 data-widget-colorbutton="false"
                                 data-widget-editbutton="false"
                                 data-widget-deletebutton="false"
                                 data-widget-fullscreenbutton="false"
                                 data-widget-custombutton="false"
                                 data-widget-collapsed="false"
                                 data-widget-sortable="false">
                                <header>

                                    <h2>Doughnut Chart </h2>

                                </header>

                                <!-- widget div-->
                                <div>

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->
                                        <input class="form-control" type="text">
                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body">

                                        <!-- this is what the user will see -->
                                        <canvas id="doughnutChart" height="120"></canvas>

                                    </div>
                                    <!-- end widget content -->

                                </div>
                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->

                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-6"
                                 data-widget-colorbutton="false"
                                 data-widget-editbutton="false"
                                 data-widget-deletebutton="false"
                                 data-widget-fullscreenbutton="false"
                                 data-widget-custombutton="false"
                                 data-widget-collapsed="false"
                                 data-widget-sortable="false">
                                <header>

                                    <h2>Pie Chart </h2>

                                </header>

                                <!-- widget div-->
                                <div>

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->
                                        <input class="form-control" type="text">
                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body">

                                        <!-- this is what the user will see -->
                                        <canvas id="pieChart" height="120"></canvas>

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

                    <!-- row -->

                    <div class="row">

                        <!-- a blank row to get started -->
                        <div class="col-sm-12">
                            <!-- your contents here -->
                        </div>

                    </div>

                    <!-- end row -->

                </section>
                <!-- end widget grid -->

            </div>
        </div>


        {{--<div class="row">--}}
            {{--<article class="col-sm-12">--}}
                {{--<div class="well well-light">--}}

                    {{--<h1><span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>Live ,--}}
                        {{--<small>Feeds</small>--}}
                    {{--</h1>--}}
                    {{--<div class="row">--}}

                        {{--<div class="col-xs-12 col-sm-6 col-md-3">--}}
                            {{--<div class="panel panel-success pricing-big">--}}

                                {{--<div class="panel-heading">--}}
                                    {{--<h3 class="panel-title">--}}
                                        {{--Users</h3>--}}
                                {{--</div>--}}
                                {{--<div class="panel-body no-padding text-align-center">--}}
                                    {{--<div class="the-price">--}}
                                        {{--<h1>--}}
                                            {{--<strong>  {{ count(\App\Http\Controllers\AppBaseController::users()) }}</strong></h1>--}}
                                    {{--</div>--}}

                                {{--</div>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-12 col-sm-6 col-md-3">--}}
                            {{--<div class="panel panel-danger pricing-big">--}}

                                {{--<div class="panel-heading">--}}
                                    {{--<h3 class="panel-title">--}}
                                        {{--Roles--}}
                                    {{--</h3>--}}
                                {{--</div>--}}
                                {{--<div class="panel-body no-padding text-align-center">--}}
                                    {{--<div class="the-price">--}}
                                        {{--<h1>--}}
                                            {{--<strong>  {{ count(\App\Http\Controllers\AppBaseController::roles()) }}</strong></h1>--}}
                                    {{--</div>--}}

                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-12 col-sm-6 col-md-3">--}}
                            {{--<div class="panel panel-teal pricing-big">--}}

                                {{--<div class="panel-heading">--}}
                                    {{--<h3 class="panel-title">--}}
                                        {{--Permissions--}}
                                    {{--</h3>--}}
                                {{--</div>--}}
                                {{--<div class="panel-body no-padding text-align-center">--}}
                                    {{--<div class="the-price">--}}
                                        {{--<h1>--}}
                                            {{--<strong>  {{ count(\App\Http\Controllers\AppBaseController::permissions()) }}</strong></h1>--}}
                                    {{--</div>--}}

                                {{--</div>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-12 col-sm-6 col-md-3">--}}
                            {{--<div class="panel panel-success pricing-big">--}}

                                {{--<div class="panel-heading">--}}
                                    {{--<h3 class="panel-title">--}}
                                        {{--Routes--}}
                                    {{--</h3>--}}
                                {{--</div>--}}
                                {{--<div class="panel-body no-padding text-align-center">--}}
                                    {{--<div class="the-price">--}}
                                        {{--<h1>--}}
                                            {{--<strong>  {{ count(\App\Http\Controllers\AppBaseController::routes()) }}</strong></h1>--}}
                                    {{--</div>--}}

                                {{--</div>--}}

                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
                {{--<section id="widget-grid" class="">--}}

                    {{--<div class="row">--}}
                        {{--<article class="col-sm-12 col-md-12 col-lg-6">--}}

                            {{--<!-- new widget -->--}}
                            {{--<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false"--}}
                                 {{--data-widget-editbutton="false">--}}



                                {{--<header>--}}
                                    {{--<span class="widget-icon"> <i class="fa fa-map-marker"></i> </span>--}}
                                    {{--<h2>Environment</h2>--}}

                                {{--</header>--}}

                                {{--<!-- widget div-->--}}
                                {{--<div>--}}

                                    {{--<div class="widget-body no-padding">--}}
                                        {{--<!-- content goes here -->--}}
                                        {{--<div class="table-responsive">--}}
                                            {{--<table class="table table-striped table-hover table-condensed">--}}

                                                {{--@foreach($environments as $env)--}}
                                                    {{--<tr>--}}
                                                        {{--<td width="120px">{{ $env['name'] }}</td>--}}
                                                        {{--<td class="text-primary">{{ $env['value'] }}</td>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                            {{--</table>--}}
                                        {{--</div>--}}
                                        {{--<!-- /.table-responsive -->--}}
                                        {{--<!-- end content -->--}}

                                    {{--</div>--}}

                                {{--</div>--}}
                                {{--<!-- end widget div -->--}}
                            {{--</div>--}}
                            {{--<!-- end widget -->--}}
                            {{--<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false">--}}


                                {{--<header>--}}
                                    {{--<span class="widget-icon"> <i class="fa fa-cog"></i> </span>--}}
                                    {{--<h2> Settings </h2>--}}

                                {{--</header>--}}

                                {{--<!-- widget div-->--}}
                                {{--<div>--}}
                                    {{--<div class="widget-body no-padding">--}}
                                        {{--<!-- content goes here -->--}}


                                        {{--<!-- end content -->--}}
                                    {{--</div>--}}

                                {{--</div>--}}
                                {{--<!-- end widget div -->--}}
                            {{--</div>--}}
                            {{--<!-- end widget -->--}}
                        {{--</article>--}}
                        {{--<article class="col-sm-12 col-md-12 col-lg-6">--}}

                            {{--<!-- new widget -->--}}
                            {{--<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"--}}
                                 {{--data-widget-fullscreenbutton="false">--}}



                                {{--<header>--}}
                                    {{--<span class="widget-icon"> <i class="fa fa-comments txt-color-white"></i> </span>--}}
                                    {{--<h2> Dependencies</h2>--}}
                                {{--</header>--}}

                                {{--<!-- widget div-->--}}
                                {{--<div>--}}

                                    {{--<div class="widget-body widget-hide-overflow no-padding">--}}
                                        {{--<!-- content goes here -->--}}
                                        {{--<div class="table-responsive">--}}
                                            {{--<table class="table table-striped table-hover table-condensed">--}}
                                                {{--@foreach($dependencies as $dependency => $version)--}}
                                                    {{--<tr>--}}
                                                        {{--<td >{{ $dependency }}</td>--}}
                                                        {{--<td><span class="label label-primary">{{ $version }}</span></td>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                            {{--</table>--}}
                                        {{--</div>--}}
                                        {{--<!-- /.table-responsive -->--}}

                                        {{--<!-- end content -->--}}
                                    {{--</div>--}}

                                {{--</div>--}}
                                {{--<!-- end widget div -->--}}
                            {{--</div>--}}
                            {{--<!-- end widget -->--}}



                        {{--</article>--}}



                    {{--</div>--}}

                    {{--<!-- end row -->--}}
                {{--</section>--}}

            {{--</article>--}}
        {{--</div>--}}
    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('page_specific_scripts')

    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="{{ asset('smartadmin/js/plugin/moment/moment.min.js') }}"></script>
    <script src="{{ asset('smartadmin/js/plugin/chartjs/chart.min.js') }}"></script>

    <script>

        $(document).ready(function() {
            var randomScalingFactor = function() {
                return Math.round(Math.random() * 1000);
                //return 0;
            };
            var randomColorFactor = function() {
                return Math.round(Math.random() * 255);
            };
            var randomColor = function(opacity) {
                return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
            };

            var LineConfig = {
                type: 'line',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [{
                        label: "My First dataset",
                        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],

                    }, {
                        label: "My Second dataset",
                        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
                    }]
                },
                options: {
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    responsive: true,
                    tooltips: {
                        mode: 'label'
                    },
                    hover: {
                        mode: 'dataset'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                show: true,
                                labelString: 'Month'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                show: true,
                                labelString: 'Value'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 100,
                            }
                        }]
                    }
                }
            };

            $.each(LineConfig.data.datasets, function(i, dataset) {
                dataset.borderColor = randomColor(0.8);
                dataset.backgroundColor = randomColor(0.8);
                dataset.pointBorderColor = randomColor(0.8);
                dataset.pointBackgroundColor = randomColor(0.8);
                dataset.pointBorderWidth = 2;
                dataset.fill = false;
                // dataset.borderColor = 'rgba(0,0,0,0.15)';
                // dataset.backgroundColor = randomColor(0);
                // dataset.pointBorderColor = 'rgba(0,0,0,0.15)';
                // dataset.pointBackgroundColor = randomColor(0.5);
                // dataset.pointBorderWidth = 1;
                // dataset.fill = false;
            });

            // bar chart example

            var barChartData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: 'Dataset 1',
                    backgroundColor: "rgba(220,220,220,0.5)",
                    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
                }, {
                    label: 'Dataset 2',
                    backgroundColor: "rgba(151,187,205,0.5)",
                    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
                }, {
                    label: 'Dataset 3',
                    backgroundColor: "rgba(151,187,205,0.5)",
                    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
                }]

            };

            // radar example

            var RadarConfig = {
                type: 'radar',
                data: {
                    labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                    datasets: [{
                        label: "My First dataset",
                        backgroundColor: "rgba(220,220,220,0.2)",
                        pointBackgroundColor: "rgba(220,220,220,1)",
                        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
                    }, {
                        label: "My Second dataset",
                        backgroundColor: "rgba(151,187,205,0.2)",
                        pointBackgroundColor: "rgba(151,187,205,1)",
                        hoverPointBackgroundColor: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
                    },]
                },
                options: {
                    legend: {
                        position: 'top',
                    },

                    scale: {
                        reverse: false,
                        ticks: {
                            beginAtZero: true
                        }
                    }
                }
            };

            // doughnut example

            var DoughtnutConfig = {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                        ],
                        backgroundColor: [
                            "#F7464A",
                            "#46BFBD",
                            "#FDB45C",
                            "#949FB1",
                            "#4D5360",
                        ],
                        label: 'Dataset 1'
                    }],
                    labels: [
                        "Red",
                        "Green",
                        "Yellow",
                        "Grey",
                        "Dark Grey"
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    }
                }
            };

            // polar chart example

            var PolarConfig = {
                data: {
                    datasets: [{
                        data: [
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                        ],
                        backgroundColor: [
                            "#F7464A",
                            "#46BFBD",
                            "#FDB45C",
                            "#949FB1",
                            "#4D5360",
                        ],
                        label: 'My dataset' // for legend
                    }],
                    labels: [
                        "Red",
                        "Green",
                        "Yellow",
                        "Grey",
                        "Dark Grey"
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Our Favorite Dataset'
                    },
                    scale: {
                        ticks: {
                            beginAtZero: true
                        },
                        reverse: false
                    },
                    animateRotate:false
                }
            };

            // pie chart example
            var PieConfig = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                        ],
                        backgroundColor: [
                            "#F7464A",
                            "#46BFBD",
                            "#FDB45C",
                            "#949FB1",
                            "#4D5360",
                        ],
                    }],
                    labels: [
                        "Red",
                        "Green",
                        "Yellow",
                        "Grey",
                        "Dark Grey"
                    ]
                },
                options: {
                    responsive: true
                }
            };

            window.myLine = new Chart(document.getElementById("lineChart"), LineConfig);
            window.myBar = new Chart(document.getElementById("barChart"), {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                }
            });
            window.myRadar = new Chart(document.getElementById("radarChart"), RadarConfig);
            window.myDoughnut = new Chart(document.getElementById("doughnutChart"), DoughtnutConfig);
            window.myPolarArea = Chart.PolarArea(document.getElementById("polarChart"), PolarConfig);
            window.myPie = new Chart(document.getElementById("pieChart"), PieConfig);


        });

    </script>
@endsection