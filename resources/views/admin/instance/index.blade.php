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

                                        {!! Form::open( ['method' => 'POST' , 'id' => 'instance_list'] ) !!}

                                            @include($view_path . '.partials._instance_list')

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

    @if (AclHelper::isRouteAccessable('admin.instance.deliverySite:GET'))
        <script>
            var parts = {};
            @forEach($data['questions'] as $ques)
                $.extend(parts, {'<?=$ques->part?>':'<?=$ques->part_name?>'});
            @endforeach

            $('table').on('click', '.addSiteDelivery', function (e) {
                e.preventDefault();
                var modal = $("#siteDeliveryModal");
                var url = $(this).data("url");
                var html = '';
                var count = 0;
                @forEach($data['questions'] as $ques)
                    html +=createLiWithAnchor(url, '<?=$ques->part?>', '<?=$ques->part_name?>', ++count);
                @endforeach

                modal.find('.modal-body div').html(html);
                modal.modal('show');
            });

            function createLiWithAnchor(url, value, text, count) {
             return '<a class="list-group-item" href="' + url + '?entry_type=' + value +'&redirectTo=part-' + count + '">' + text + '</a>';
            }
            setTimeout(function () {
                $('.alert.alert-important').slideUp();
            }, 15000);
        </script>

        <!-- Instance Delete Confirmation Modal -->
        <div class="modal fade" id="siteDeliveryModal" tabindex="-1" role="dialog" aria-labelledby="siteDeliveryModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <input type="hidden" name="id" class="instanceId">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title text-danger">{{ trans($trans_path . 'general.common.select-entry-type') }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

    {!! Html::script('smartadmin/js/datatable.js') !!}
    {!! Html::script('smartadmin/js/datatable.bootstrap.js') !!}
    <script>
        $('.modal').on('mouseenter', '.list-group-item', function () {
            $(this).addClass('active');
        }).on('mouseleave', '.list-group-item', function () {
            $(this).removeClass('active');
        });


        //initialize dataTables
//        var table = $('table.table').DataTable({
//            "dom": '<t>r' +
//            '<"card-footer card-pagination"<"row"<"col-md-12 text-right"><"col-md-8"p><"col-md-4"l>>>',
//            "oLanguage": {
//                "sLengthMenu": " _MENU_ ",
//                "sSearchPlaceholder": "Search",
//                "oPaginate": {
//                    "sNext": "<span aria-hidden='true'>»</span><span class='sr-only'>Next</span>",
//                    "sPrevious": "<span aria-hidden='true'>«</span><span class='sr-only'>Previous</span>"
//                }
//            }
//        });
//        $('#searchField').keyup(function(){
//            table.search($(this).val()).draw() ;
//        });

        var dataTableConfigVariable = {
            route_url: {
                dataTable_url:  '{{ route("admin.instance.search") }}'
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'indicators', name: 'indicators'},
                {data: 'user', name: 'user'},
                {data: 'facility_name', name: 'facility_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'built_stage', name: 'built_stage'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
            ],
            orderColumn: 0,
            buttons: false,
            pagination: parseInt('{{ AppHelper::getConfigValue('ADMIN-PAGINATION-LIMIT') }}')
        };
    </script>
    @include('admin.partials.list_page_script_datatables')


    @if (AclHelper::isRouteAccessable('admin.instance.destroy:GET'))

        <!-- Instance Delete Confirmation Modal -->
        <div class="modal fade" id="instanceDeleteModal" tabindex="-1" role="dialog" aria-labelledby="instanceDeleteModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <input type="hidden" name="id" class="faqId">
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
                        <a href="#" type="button" class="btn btn-danger deleteInstanceFinal">
                            {{ trans("general.button.delete") }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <script>
            $('table').on('click', '.deleteInstance', function (e) {
                e.preventDefault();
                var modal = $("#instanceDeleteModal");
                var url = $(this).data("url");
                var title = $(this).data("title");
                modal.find('.modal-title span').html(title);
                modal.find('.modal-footer .deleteInstanceFinal').attr('href', url);
                modal.modal('show');
            });
        </script>
    @endif

@endsection