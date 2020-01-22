@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.create.title'))
@section('page_description', trans($trans_path.'general.page.create.description'))
@section('page_specific_styles')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/nepali_datepicker.min.css') }}" />--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('nepali_datepicker/nepali.datepicker.v2.2.min.css') }}" />

<style>
        .smart-form section {
            margin-bottom: 25px;
        }
        .select2-selection {
            padding-left: 10px;
        }
        .select2.select2-container {
            width: 100% !important;
        }
        .evaluationTeamData .btn, .evaluationTeamAddForm .btn,
        .indicatorData .btn, .indicatorForm .btn {
            padding: 5px 10px 5px 5px;
        }
        .evaluationTeamData .btn, .evaluationTeamAddForm .btn,
        .indicatorData .btn, .indicatorForm .btn {
            padding: 5px 10px 5px 5px;
        }
        .select2-container .select2-choice, .select2-selection{
            border: 0;
            border-bottom: 1px solid #ccc;
        }
    </style>
@endsection

@section('content')
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">

            <div class="row">
                <form id="instanceSetup" method="post" action="{{ route('admin.instance.store') }}" novalidate="novalidate">
                    {!! csrf_field() !!}
                    <div id="bootstrap-wizard-1" class="col-sm-12">
                        @php
                            $siteFollowUp = null;
                            $tabCount = 1;
                            if ($data['previous_instance'] && count($data['previous_instance']->siteFollowUp) > 0)
                                $siteFollowUp = $data['previous_instance']->siteFollowUp;
                        @endphp
                        @include($view_path . '.partials.tabs')
                        @include($view_path . '.partials.tab_content')
                    </div>
                </form>
            </div>

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->
@endsection
@section('page_specific_scripts')
    @include($view_path . '.partials.common_script')
@endsection
