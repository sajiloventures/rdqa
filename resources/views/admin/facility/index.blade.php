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
                                        <span class="pull-left">
                                            <div id="buttons"></div>
                                        </span>
                                        <span class="pull-right">
                                            <input type="text" class="form-control" id="searchField" placeholder="Search" />
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 5px 20px 0 20px;">

                                        {!! Form::open( ['method' => 'POST' , 'id' => 'facility_list'] ) !!}

                                            @include($view_path . '.partials._facility_list')

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
    <script>
        var dataTableConfigVariable = {
            route_url: {
                dataTable_url:  '{{ route("admin.facility.search") }}'
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'province_name', name: 'province_name'},
                {data: 'district_name', name: 'district_name'},
                {data: 'palika_name', name: 'palika_name'},
                {data: 'hf_name', name: 'hf_name'},
                {data: 'urban_rural', name: 'urban_rural'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
            ],
            orderColumn: 0,
            lengthMenu: [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
            buttons: false,
            pagination: 50
        };
    </script>
    @include('admin.partials.list_page_script_datatables')

    @if (AclHelper::isRouteAccessable('admin.facility.delete:GET'))
        <script>
            $('table').on('click', '.deleteFacility', function (e) {
                e.preventDefault();
                var modal = $("#facilityModal");
                modal.find('.modal-title span').html($(this).attr("attr-name"));
                modal.find('.deleteFacilityFinal').attr('href', $(this).attr("attr-facility-code"));
                modal.modal('show');
            });
        </script>

        <!-- Facility Delete Confirmation Modal -->
        <div class="modal fade" id="facilityModal" tabindex="-1" role="dialog" aria-labelledby="facilityModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <input type="hidden" name="id" class="facilityId">
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
                        <a href="#" type="button" class="btn btn-danger deleteFacilityFinal">
                            {{ trans("general.button.delete") }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endif

@endsection