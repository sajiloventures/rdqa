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
        .bootstrapWizard li {
            width: 45%;
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

            <div class="row">
                <form id="part3" method="post" action="{{ route('admin.instance.deliverySite.partThree.store', $data['instance']->id) }}" novalidate="novalidate">
                    {!! csrf_field() !!}
                    <div id="part-3-wizard" class="col-sm-12">
                        @include($view_path . '.partials.part-3.tabs')
                        @include($view_path . '.partials.part-3.tab_content')
                    </div>
                </form>
            </div>

        </section>

    </div>
    <!-- END MAIN CONTENT -->
@endsection
@section('page_specific_scripts')
    {!! Html::script('nepali_datepicker/nepali.datepicker.v2.2.min.js') !!}
    <script src="{{ asset('smartadmin/js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script>

        //disable wizard click
        $('.bootstrapWizard.form-wizard a').click(function (e) {
            e.preventDefault();
            return false;
        });

        $('.actionPlanTable tbody tr').each(function () {
            var id = $(this).attr('id');
            $(this).find('#timeLine_' + id).nepaliDatePicker({
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,
                ndpEnglishInput: ('timeLineEng_' + id)
            });
        });

        var systemAssessmentSelectHtml = '<td>' +
            '<select name="questionId[]" class="form-control identifiedInput">' +
            '<option value="data-verification">Data Verification</option>' +
                @foreach($data['system_assessment_data'] as $sAd)
                    '<option value="{{ $sAd->id }}">{{ $sAd->type_name }}</option>' +
                @endforeach
            '</select>' +
            '</td>';

        $('form').on('click', '.addPlanningRow', function (e) {
            e.preventDefault();
            var parent = $('.actionPlanTable tbody');
            var id = 0;
            if (parent.find('tr').length > 0)
                id = parent.find('tr:last-child').attr('id');

            var html = '<tr id="' + (++id) + '">\n' + systemAssessmentSelectHtml +
                '<td style="display:none"><input type="hidden" name="plan_id[]" class="form-control" />' +
                '<input type="text" name="identified[]" class="form-control identifiedInput" value="nn"/></td>\n' +
                '<td><input type="text" name="description[]" class="form-control identifiedInput" /></td>\n' +
                '<td><input type="text" name="responsible[]" class="form-control identifiedInput" /></td>\n' +
                '<td><input type="text" id="timeLine_' + id + '" name="timeLine[]" class="form-control timeLine identifiedInput" />' +
                '<input type="hidden" id="timeLineEng_' + id + '" name="timeLineEng[]" class="form-control timeLineEng" /></td>\n' +
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

        formWizard($('#part-3-wizard'));

        function formWizard(wizard) {
            wizard.bootstrapWizard({
                'tabClass': 'form-wizard',
                'onNext': function (tab, navigation, index) {

                    $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
                        'complete');
                    $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
                        .html('<i class="fa fa-check"></i>');
                },
                'onTabShow': function (tab, navigation, index) {
                    if ($('.bootstrapWizard.form-wizard li').length === index + 1) {
                        $('li.next').hide();
                        $('li.save').show();
                    } else {
                        $('li.next').show();
                        $('li.save').hide();
                    }

                }
            });
        }

        //remove it when not required
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
