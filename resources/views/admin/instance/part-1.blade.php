@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.create.title'))
@section('page_description', trans($trans_path.'general.page.create.description'))
@section('page_specific_styles')
    <style>
        .smart-form section {
            margin-bottom: 25px;
        }
        .evaluationTeamData .btn, .evaluationTeamAddForm .btn,
        .indicatorData .btn, .indicatorForm .btn {
            padding: 5px 10px 5px 5px;
        }
        .evaluationTeamData .btn, .evaluationTeamAddForm .btn,
        .indicatorData .btn, .indicatorForm .btn {
            padding: 5px 10px 5px 5px;
        }
        thead tr td, thead tr th {
            vertical-align: bottom !important;
        }
        tbody td {
            position: relative !important;
        }
        table span.col {
            padding-left: 2px !important;
            padding-right: 2px !important;
        }
        table input.col {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }
        table span {
            overflow-x: scroll;
        }
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
        .dividerColumn {
            position: absolute;
            right: 50%;
            bottom: 10px;
            font-style: normal;
            font-size: 15px;
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

        <!-- widget grid -->
        <section id="widget-grid" class="">

            <div class="row">
                @php $questionNumber=0; @endphp
                <form id="part1" method="post" action="{{ route('admin.instance.deliverySite.partOne.store', $data['instance']->id) }}" novalidate="novalidate">
                    {!! csrf_field() !!}
                    <div id="part-1-wizard" class="col-sm-12">
                        @include($view_path . '.partials.part-1.tabs')
                        @include($view_path . '.partials.part-1.tab_content')
                    </div>
                    <div style="display: none;">
                        <input type="hidden" name="redirectTo" value="{{ isset($data['redirectTo']) ? $data['redirectTo'] : null }}">
                    </div>
                </form>
            </div>

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection
@section('page_specific_scripts')
    <script src="{{ asset('smartadmin/js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //disable wizard click
            $('.bootstrapWizard.form-wizard a').click(function (e) {
                e.preventDefault();
                return false;
            });
            var compareA = null;
            var compareB = null;
            $('.table').on('input', '.compare_a', function () {
                var parent = $(this).closest('tbody');
                var indicatorId = $(this).data('indicator');
                setCompareValue($(this), parent.find('.compare_b[data-indicator="' + indicatorId + '"]'));
                calculatePercentageAndShow(parent.find('.compare_result_' + indicatorId));
            });
            $('.table').on('input', '.compare_b', function () {
                var parent = $(this).closest('tbody');
                var indicatorId = $(this).data('indicator');
                setCompareValue(parent.find('.compare_a[data-indicator="' + indicatorId + '"]'), $(this));
                calculatePercentageAndShow(parent.find('.compare_result_' + indicatorId));
            });
            $('.table').on('input', '.compare_a_a, .compare_b_a', function () {
                var parent = $(this).closest('tbody');
                var indicatorId = $(this).data('indicator');
                setCompareValue(parent.find('.compare_a_a[data-indicator="' + indicatorId + '"]'), parent.find('.compare_b_a[data-indicator="' + indicatorId + '"]'));
                calculatePercentageAndShow(parent.find('.compare_result_' + indicatorId + '_a'), true);
            });
            $('.table').on('input', '.compare_a_b, .compare_b_b', function () {
                var parent = $(this).closest('tbody');
                var indicatorId = $(this).data('indicator');
                setCompareValue(parent.find('.compare_a_b[data-indicator="' + indicatorId + '"]'), parent.find('.compare_b_b[data-indicator="' + indicatorId + '"]'));
                calculatePercentageAndShow(parent.find('.compare_result_' + indicatorId + '_b'), true);
            });

            $('.table').on('input', '.compare_3_a, .compare_3_b', function () {
                getPercentOfCC3($(this));
            });
            $('.compare_3_a, .compare_3_b').each(function () {
                getPercentOfCC3($(this));
            });

            function getPercentOfCC3($this) {
                var parent = $this.closest('tbody');
                var indicatorId = $this.data('indicator');
                var selectedClass = $this.hasClass('compare_3_a') ? 'compare_3_a' : 'compare_3_b';
                var selectedSpan = $this.hasClass('compare_3_a') ? '_a' : '_b';
                compareB = compareA = 0;
                $('.' + selectedClass + '[data-indicator="' + indicatorId +'"]').each(function (value) {
                    compareA = parseFloat($(this).val());
                    compareB += compareA;
                });
                compareB -=compareA;

                calculatePercentageAndShow(parent.find('.compare_result_' + indicatorId + selectedSpan));

            }

            function setCompareValue($firstSelector, $secondSelector) {
                compareA = parseFloat($firstSelector.val());
                compareB = parseFloat($secondSelector.val());
            }

            function calculatePercentageAndShow($selector, BbyA) {
                var percentage = 0;
                if(!BbyA)
                    BbyA = false;

                if (compareA && compareB) {
                    if (BbyA)
                        percentage = (compareB / compareA) * 100;
                    else
                        percentage = (compareA / compareB) * 100;
                }

                $selector.html(percentage.toFixed(2) + '%');
            }

            $('.yesNoCheck').each(function () {
                addRequiredToRemarks($(this));
            });

            $('.table').on('change', '.yesNoCheck', function () {
                addRequiredToRemarks($(this));
            });

            function addRequiredToRemarks($this) {
                if ($this.val().toLowerCase() === 'no') {
                    $this.closest('td').find('.colRemarks').attr('required', 'required');
                } else {
                    $this.closest('td').find('.colRemarks').removeAttr('required');
                }
            }

            validateForm($("#part1"));
            formWizard($('#part-1-wizard'), $("#part1"));
        });
    </script>
    @include($view_path . 'partials.parts_common_scripts')
@endsection
