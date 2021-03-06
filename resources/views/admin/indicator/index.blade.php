@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.index.title'))
@section('page_description', trans($trans_path.'general.page.index.description'))
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
                                @if (AclHelper::isRouteAccessable($base_route . '.create:GET'))
                                    <a class="btn btn-sm txt-color-white" href="{!! route($base_route . '.create') !!}" title="{{ trans($admin_trans_path.'general.button.create') }}">
                                        <i class="fa fa-lg fa-plus-square"></i>
                                    </a>
                                @endif
                            </span>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-md-12" style="padding: 5px 20px 0 20px;">
                                        <div class="pull-left">
                                            @if (AclHelper::isRouteAccessable($base_route . '.enable_all:GET'))
                                                <div class="form-group">
                                                    <label class="select">

                                                        <select class="form-control select2" name="disableByProgram">
                                                            <option value="">Select Program</option>
                                                            @foreach($data['indicator-program'] as $program)
                                                                <option value="{{$program->program}}">{{$program->program}}</option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-sm btn-default enableDisableProgram" data-enable="0"><i class="fa fa-check-circle-o"></i> Enable</a>
                                                        <a href="#" class="btn btn-sm btn-default enableDisableProgram" data-enable="1"><i class="fa fa-remove"></i> Disable</a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div id="buttons"></div>
                                        </div>
                                        <span class="pull-right">
                                            <input type="text" class="form-control" id="searchField" placeholder="Search" />
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 5px 20px 0 20px;">

                                        {!! Form::open( ['method' => 'POST' , 'id' => 'indicator_list'] ) !!}

                                            @include($view_path . '.partials._indicator_list')

                                        {!! Form::close() !!}
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
    @if (AclHelper::isRouteAccessable($base_route . '.enable_all:GET'))
        <script>
            $('.enableDisableProgram').on('click', function (e) {
                var program = $('select[name="disableByProgram"]').val();
                if (program) {
                    var enable = $(this).data('enable');
                    var url = "{{route('admin.indicator.enable_all')}}" + '?program=' + program + "&enable=" + enable;
                    window.location.replace(url);
                } else {
                    alert('Please select program');
                    return false;
                }
            });
        </script>
    @endif
    <script>
        var dataTableConfigVariable = {
            route_url: {
                dataTable_url:  '{{ route("admin.indicator.search") }}'
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'program', name: 'program'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
            ],
            orderColumn: 0,
            lengthMenu: [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
            buttons: false,
            pagination: 50
        };
    </script>
    @include('admin.partials.list_page_script_datatables')

    @if (AclHelper::isRouteAccessable('admin.indicator.delete:GET'))
        <script>
            $('table').on('click', '.deleteIndicator', function (e) {
                e.preventDefault();
                var modal = $("#indicatorModal");
                modal.find('.modal-title span').html($(this).attr("attr-name"));
                modal.find('.deleteIndicatorFinal').attr('href', $(this).attr("attr-indicator-code"));
                modal.modal('show');
            });
        </script>

        <!-- Indicator Delete Confirmation Modal -->
        <div class="modal fade" id="indicatorModal" tabindex="-1" role="dialog" aria-labelledby="indicatorModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <input type="hidden" name="id" class="indicatorId">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title text-danger">{{ trans($trans_path . 'general.delete.title') }} : <span></span></h5>
                    </div>
                    <div class="modal-body">
                        <h5>
                            {{ trans($trans_path . 'general.delete.sure') }}
                            <br />
                            <small>{{ trans($trans_path . 'general.delete.message') }}</small>
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            {{ trans("general.button.cancel") }}
                        </button>
                        <a href="#" type="button" class="btn btn-danger deleteIndicatorFinal">
                            {{ trans("general.button.delete") }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endif

@endsection