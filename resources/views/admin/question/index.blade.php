@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.index.title'))
@section('page_description', trans($trans_path.'general.page.index.description'))
@section('page_specific_styles')
    <style>
        #divSmallBoxes {
            top: 10%;
        }
        .dd{
            max-width: 90%;
        }
        .dd3-content
    </style>
@endsection
@section('content')
    <!-- MAIN CONTENT -->
    <div id="content">
    @include('admin.partials._status')
    <!-- widget grid -->
        <section class="" id="widget-grid">
            <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget jarviswidget-color-blueDark"
                         data-widget-editbutton="false"
                         data-widget-colorbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         id="wid-id-0">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-user-secret"></i> </span>
                            <h2>{{ trans($trans_path.'general.content.list') }} </h2>
                            <span class="pull-right">
                                {{--<a class="btn btn-sm txt-color-white" href="{!! route($base_route . '.create') !!}" title="{{ trans($admin_trans_path.'general.button.create') }}">--}}
                                   {{--<i class="fa fa-lg fa-plus-square"></i>--}}
                               {{--</a>--}}
                            </span>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 5px 20px 0 20px;">
                                        @include($view_path . '.partials._question_list')
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

    <script src="{{ asset('smartadmin/js/plugin/jquery-nestable/jquery.nestable.min.js') }}"></script>
    @include($view_path . '.partials.script')

    <div class="modal fade" id="editTitleModal" tabindex="-1" role="dialog" aria-labelledby="editTitleModal" aria-hidden="true"></div>
@endsection