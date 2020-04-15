<script>
    Chart.pluginService.register({
        beforeInit: function(chart) {
            var hasWrappedTicks = chart.config.data.labels.some(function(label) {
                return label.indexOf('\n') !== -1;
            });

            if (hasWrappedTicks) {
                // figure out how many lines we need - use fontsize as the height of one line
                var tickFontSize = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].ticks.fontSize, Chart.defaults.global.defaultFontSize);
                var maxLines = chart.config.data.labels.reduce(function(maxLines, label) {
                    return Math.max(maxLines, label.split('\n').length);
                }, 0);
                var height = (tickFontSize + 2) * maxLines + (chart.options.scales.xAxes[0].ticks.padding || 0);

                // insert a dummy box at the bottom - to reserve space for the labels
                Chart.layoutService.addBox(chart, {
                    draw: Chart.helpers.noop,
                    isHorizontal: function() {
                        return true;
                    },
                    update: function() {
                        return {
                            height: this.height
                        };
                    },
                    height: height,
                    options: {
                        position: 'bottom',
                        fullWidth: 1,
                    }
                });

                // turn off x axis ticks since we are managing it ourselves
                chart.options = Chart.helpers.configMerge(chart.options, {
                    
                    responsive: true,

                    scales: {
                          yAxes: [{
                ticks: {
                   // display:false,
                    beginAtZero: true
                   // fontSize: 0,
                }
            }],
                        xAxes: [{
                            ticks: {
                                display: false,
                                // set the fontSize to 0 so that extra labels are not forced on the right side
                                fontSize: 0
                            }
                        }]
                    }
                });

                chart.hasWrappedTicks = {
                    tickFontSize: tickFontSize
                };
            }
        },
        afterDraw: function(chart) {
            if (chart.hasWrappedTicks) {
                // draw the labels and we are done!
                chart.chart.ctx.save();
                var tickFontSize = chart.hasWrappedTicks.tickFontSize;
                var tickFontStyle = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].ticks.fontStyle, Chart.defaults.global.defaultFontStyle);
                var tickFontFamily = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].ticks.fontFamily, Chart.defaults.global.defaultFontFamily);
                var tickLabelFont = Chart.helpers.fontString(tickFontSize, tickFontStyle, tickFontFamily);
                chart.chart.ctx.font = tickLabelFont;
                chart.chart.ctx.textAlign = 'center';
                var tickFontColor = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].fontColor, Chart.defaults.global.defaultFontColor);
                chart.chart.ctx.fillStyle = tickFontColor;

                var meta = chart.getDatasetMeta(0);
                var xScale = chart.scales[meta.xAxisID];
                var yScale = chart.scales[meta.yAxisID];

                chart.config.data.labels.forEach(function(label, i) {
                    if (typeof label === 'string')
                        label = label.split('\n');
                    label.forEach(function(line, j) {
                        chart.chart.ctx.fillText(line, xScale.getPixelForTick(i + 0.5), (chart.options.scales.xAxes[0].ticks.padding || 0) + yScale.getPixelForValue(yScale.min) +
                            // move j lines down
                            j * (chart.hasWrappedTicks.tickFontSize + 2));
                    });
                });

                chart.chart.ctx.restore();
            }
        }
    });

    $(document).ready(function() {

        // Bar chart for data verification
        var indicatorLabel = [];
        var dataVerificationData = [];

        @foreach($data['reporting-performance'] as $rp)
            @if (isset($data['selected-indicators']) && isset($data['selected-indicators'][$rp->indicator_id]))
                indicatorLabel.push("{!! AppHelper::addNewLineInText($data['selected-indicators'][$rp->indicator_id]['name']) !!}");
            @else
                indicatorLabel.push('');
            @endif
                dataVerificationData.push(parseFloat('{{AppHelper::getPercentage($rp->value, $rp->value_2)}}'));
        @endforeach

        var graphBarCodeNumber = indicatorLabel.length < 6 ? indicatorLabel.length : 6;

        var parentLabel = indicatorLabel;
        if (indicatorLabel.length > graphBarCodeNumber)
            indicatorLabel = indicatorLabel.slice(0, graphBarCodeNumber);

        var parentDataVerificationData = dataVerificationData;
        if (dataVerificationData.length > (graphBarCodeNumber - 1))
            dataVerificationData = dataVerificationData.slice(0, (graphBarCodeNumber));

        var checkBoxContainer = $('.dataVerificationCheckBox .dropdown-menu');
        $.each(parentLabel, function (key, value) {
            addCheckBoxOptions($('.dataVerificationCheckBox .dropdown-menu'), key, value);
            addCheckBoxOptions($('.crossCheck1CheckBox .dropdown-menu'), key, value);
            addCheckBoxOptions($('.crossCheck2CheckBox .dropdown-menu'), key, value);
            addCheckBoxOptions($('.crossCheck3CheckBox .dropdown-menu'), key, value);
        });
        function addCheckBoxOptions(checkBoxContainer, key, value) {
            if (key === 0)
            checkBoxContainer.html('');

            var checked = '';
            if (key <= graphBarCodeNumber - 1)
                checked = 'checked';

            checkBoxContainer.append('<li><a href="#" class="small" data-value="' + key +'" tabIndex="-1"><input type="checkbox" value="' + value +'" ' + checked + ' />&nbsp;' + value +'</a></li>');
        }

        // bar chart example
        var barChartForDataVerification = {
            labels: indicatorLabel,
            datasets: [{
                label: '[A/B]',
                backgroundColor: "rgb(12, 98, 145, 0.8)",
                data: dataVerificationData
            }
            ]

        };

        // bar chart for cross check 1
        var crossCheck1Data1 = [];

        @foreach($data['cross-check-1'] as $rp)
            crossCheck1Data1.push(parseFloat('{{AppHelper::getPercentage($rp->value_2, $rp->value)}}'));
        @endforeach

        var parentCrossCheck1Data1 = crossCheck1Data1;
        if (crossCheck1Data1.length > (graphBarCodeNumber - 1))
            crossCheck1Data1 = crossCheck1Data1.slice(0, (graphBarCodeNumber));

        // bar chart example
        var barChartForCrossCheck1 = {
            labels: indicatorLabel,
            datasets: [{
                label: '[B/A]',
                backgroundColor: "rgb(12, 98, 145, 0.8)",
                data: crossCheck1Data1
            }
            ]

        };

        // bar chart for cross check 2
        var crossCheck2Data1 = [];

        @foreach($data['cross-check-2'] as $rp)
            crossCheck2Data1.push(parseFloat('{{AppHelper::getPercentage($rp->value_2, $rp->value)}}'));
        @endforeach

        var parentCrossCheck2Data1 = crossCheck2Data1;
        if (crossCheck2Data1.length > (graphBarCodeNumber - 1))
            crossCheck2Data1 = crossCheck2Data1.slice(0, (graphBarCodeNumber));

        // bar chart example
        var barChartForCrossCheck2 = {
            labels: indicatorLabel,
            datasets: [{
                label: '[B/A]',
                backgroundColor: "rgb(12, 98, 145, 0.8)",
                data: crossCheck2Data1
            }
            ]

        };

        // bar chart for cross check 3
        var crossCheck3Data1 = [];

        @foreach($data['cross-check-3'] as $rp)
            crossCheck3Data1.push(parseFloat('{{AppHelper::getPercentage(($rp->value_1_total - $rp->value), $rp->value)}}'));
        @endforeach

        var parentCrossCheck3Data1 = crossCheck3Data1;
        if (crossCheck3Data1.length > (graphBarCodeNumber - 1))
            crossCheck3Data1 = crossCheck3Data1.slice(0, (graphBarCodeNumber));

        // bar chart example
        var barChartForCrossCheck3 = {
            labels: indicatorLabel,
            datasets: [{
                label: '[B/A]',
                backgroundColor: "rgb(12, 98, 145, 0.8)",
                data: crossCheck3Data1
            }]

        };

        var dataVerificationBarChart = initializeBarChart("dataVerificationBarChart", barChartForDataVerification);
        var crossCheck1BarChart = initializeBarChart("crossCheck1BarChart", barChartForCrossCheck1);
        var crossCheck2BarChart = initializeBarChart("crossCheck2BarChart", barChartForCrossCheck2);
        var crossCheck3BarChart = initializeBarChart("crossCheck3BarChart", barChartForCrossCheck3);

        $( '.dataVerificationCheckBox .dropdown-menu' ).on( 'click', 'a', function() {
            displayBar($(this), dataVerificationBarChart, parentDataVerificationData);
            return false;
        });

        $( '.crossCheck1CheckBox .dropdown-menu' ).on( 'click', 'a', function() {
            displayBar($(this), crossCheck1BarChart, parentCrossCheck1Data1);
            return false;
        });
        $( '.crossCheck2CheckBox .dropdown-menu' ).on( 'click', 'a', function() {
            displayBar($(this), crossCheck2BarChart, parentCrossCheck2Data1);
            return false;
        });
        $( '.crossCheck3CheckBox .dropdown-menu' ).on( 'click', 'a', function() {
            displayBar($(this), crossCheck3BarChart, parentCrossCheck3Data1);
            return false;
        });

        function displayBar($this, chart, parentData) {

            var checkbox = $this.find('input[type="checkbox"]');
            var value = checkbox.val();
            var key = checkbox.closest('a.small').data('value');
            if (checkbox.is(':checked')) {
                checkbox.prop('checked', false );
                removeData(chart, value, parentData[key]);
            } else {
                checkbox.prop('checked', true);
                addData(chart, value, parentData[key]);
            }
        }


        // radar for system assessment

        var radarLabel = [];
        var radarData = [];
        @foreach($data['system-assessment'] as $sa)
            radarLabel.push("{!! $sa->name !!}");
            radarData.push("{{ AppHelper::getPercentage($sa->total, $sa->number, 2, false) }}");
        @endforeach

        var RadarConfig = {
                type: 'radar',
                data: {
                    labels: radarLabel,
                    datasets: [{
                        label: "value ",
                        backgroundColor: "rgb(56, 126, 165, 0.5)",
                        pointBackgroundColor: "#7e1946",
                        data: radarData
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        display: false,
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
        window.myRadar = new Chart(document.getElementById("radarChart"), RadarConfig);
    });

    function initializeBarChart(id, config, displayLegend) {
        if (!displayLegend)
            displayLegend = false;
        return new Chart(document.getElementById(id), {
            type: 'bar',
            data: config,
            options: {
                responsive: true,
                barShowLabels: false,
                legend: {
                    display: displayLegend,
                    position: 'top'
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            maxRotation: 0
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback: function (value, index, values) {
                                return (value.toFixed(2) + '%');
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += Math.round(tooltipItem.yLabel * 100) / 100;
                            return label + '%';
                        }
                    }
                }
            },
            plugins: [{
                beforeInit: function (chart) {
                    chart.data.labels.forEach(function (e, i, a) {
                        if (/\n/.test(e)) {
                            a[i] = e.split(/\n/)
                        }
                    })
                }
            }]
        });

    }


    function addData(chart, label, data) {
        chart.data.labels = resetDataIndexes(chart.data.labels);
        var key = $.inArray(label, chart.data.labels);
        if (key === -1) {
            chart.data.labels.push(label);
            chart.data.datasets.forEach((dataset) => {
                dataset.data.push(data);
            });
            chart.update();
        }

    }

    function removeData(chart, label, data) {

        // reset indexes of an array (selected chart labels)
        chart.data.labels = resetDataIndexes(chart.data.labels);

        var key = $.inArray(label, chart.data.labels);
        if (key !== -1) {
            delete chart.data.labels[key];
            chart.data.labels = resetDataIndexes(chart.data.labels);
            if (chart.data.datasets.length > 0) {
                delete chart.data.datasets[0].data[key];
                chart.data.datasets[0].data = resetDataIndexes(chart.data.datasets[0].data);
            }
            chart.update();
        }

//        chart.data.labels.pop();
//        chart.data.datasets.forEach((dataset) => {
//            dataset.data.pop();
//        });
//        chart.update();
    }

    function resetDataIndexes(data) {
        return data.filter(function (item) {
            return item !== undefined;
        });
    }

</script>