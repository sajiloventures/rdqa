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
            top: 35%;
            font-style: normal;
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
                <form id="part2" method="post" action="{{ route('admin.instance.deliverySite.partTwo.store', $data['instance']->id) }}" novalidate="novalidate">
                    {!! csrf_field() !!}
                    <div id="part-2-wizard" class="col-sm-12">
                        @include($view_path . '.partials.part-2.tabs')
                        @include($view_path . '.partials.part-2.tab_content')
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

    @include($view_path . 'partials.parts_common_scripts')

    <script>
        $(document).ready(function() {
            //disable wizard click
            $('.bootstrapWizard.form-wizard a').click(function (e) {
                e.preventDefault();
                return false;
            });

            $('.yesNoPartlyCheck').each(function () {
                addRequiredToRemarks($(this));
                changeColor($(this));
            });

            $('.table').on('change', '.yesNoPartlyCheck', function () {
                addRequiredToRemarks($(this));
                changeColor($(this));
            });

            function addRequiredToRemarks($this) {
                if (parseInt($this.val()) === 0 || parseInt($this.val()) === 1 || parseInt($this.val()) === 2) {
                    $this.closest('tr').find('.colRemarks').attr('required', 'required');
                } else {
                    $this.closest('tr').find('.colRemarks').removeAttr('required');
                }
            }

            function changeColor($this) {
                $this.css('background', 'white');
                var value = parseInt($this.val());
                if (value === 1)
                    $this.css('background', 'red');
                if (value === 2)
                    $this.css('background', 'yellow');
                if (value === 3)
                    $this.css('background', '#25d425');
            }

            validateForm($("#part2"));
            formWizard($('#part-2-wizard'), $("#part2"));
        });
    </script>
@endsection
