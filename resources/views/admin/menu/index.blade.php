@extends('admin.layouts.master')

@section('page_specific_styles')

    <link href="{{ asset("/bower_components/DragAndDrop/source/angular-ui-tree.css") }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset("/bower_components/DragAndDrop/examples/css/app.css") }}" rel="stylesheet" type="text/css"/>

    <style>
        .tree-node {
            padding: 4px;
            margin-bottom: 9px;
            border-radius: 3px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 0 3px 0 rgba(0, 0, 0, 0.03);
        }

        .tree-node .btn {
            display: none;
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            border-radius: 0px;
        }

        .tree-node:hover .btn {
            display: block;
        }

        .tree-node i.fa {
            padding: 6px 9px;
            background: rgba(51, 51, 51, 0.14);
            border-radius: 3px;
        }

        .table-hover tr td:hover:nth-child(1), .table-hover tr td:hover:nth-child(2) {
            cursor: pointer;
            text-decoration: underline;
        }

        .fa.fa-chain-broken {
            margin-left: 15px;
        }

        .tree-node .enableDisable {
            display: block;
        }
    </style>

    <!-- Datatables -->
    <link rel="stylesheet" href="{{ asset(config('rdqa.asset_path.admin.tree_css').'datatables.min.css') }}">
@endsection

@section('top-bar')

    @include($view_path.'.partials.top_nav')

@endsection

@section('content')
    <div class="menu _mlr20" ng-app="dragAndDrop">

        <div class="card" ng-controller="ConnectedTreesCtrl">

            <div class="card-header bg-light">
                @include($view_path.'.partials._searchField_Action_button')
            </div>

            <div class="card-block">
                <div class="row">

                    {!! Form::open( ['method' => 'POST' , 'id' => 'menu_list'] ) !!}

                    @include($view_path . '.partials._listMenu')


                    <div class="clearfix"></div>
                    <div class="col-md-12" style="margin-top: 10px">

                        @include('admin.menu.partials._message_display')

                        <a ng-if="changeData == true" ng-click="updateData(menuId, tree1)" href="#"
                           title="{{ trans('general.button.update') }}"
                           class="btn-xs-fixed pull-right btn-sm btn btn-labeled btn-primary">
                    <span class="btn-label">
                        <i class="fa fa-pencil-square-o"></i>
                    </span>
                            {{ trans('general.button.update') }}
                        </a>
                    </div>

                    <!-- display all pages -->
                    <div class="col-md-3">
                        @include('Admin')
                    </div>
                    <!-- display drag and drop pages -->
                    <div class="col-md-9">
                        @include('admin.menu.partials._display_drag_drop_pages_right_side')
                    </div>
                    <!-- Temporary page edit add modal -->
                    @include('admin.menu.partials._edit_page_modal')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>




@endsection

@section('page_specific_scripts')

    <!-- includes for drag and drop -->
    <!-- JavaScript -->
    <!--[if IE 8]>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/es5-shim/3.4.0/es5-shim.min.js"></script>
    <![endif]-->


    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/bower_components/angular-route.min.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/bower_components/ui-bootstrap-tpls.js") }}"></script>

    <script src="{{ asset("/bower_components/DragAndDrop/source/main.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/controllers/handleCtrl.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/controllers/nodeCtrl.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/controllers/nodesCtrl.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/controllers/treeCtrl.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/directives/uiTree.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/directives/uiTreeHandle.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/directives/uiTreeNode.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/directives/uiTreeNodes.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/source/services/helper.js") }}"></script>

    <script src="{{ asset("/bower_components/DragAndDrop/examples/js/app.js") }}"></script>
    <script src="{{ asset("/bower_components/DragAndDrop/examples/js/connected-trees.js") }}"></script>

    <script src="{{ asset(config('rdqa.asset_path.admin.vendor').'jquery.dataTables.js') }}"></script>
    <script src="{{ asset(config('rdqa.asset_path.admin.vendor').'dataTables.bootstrap.js') }}"></script>

    <script>
        //        initialize datatables
        var table = $('table.table').DataTable({
            "dom": '<t>',
            "columnDefs": [
                {"orderable": false, "searchable": false, "targets": 0},
                {"orderable": false, "searchable": false, "targets": 4}
            ],
            "oLanguage": {
                "sLengthMenu": " _MENU_ ",
                "sSearchPlaceholder": "Search",
            },
            'order': [[1, 'asc']]
        });

        var route_url = {
            enableAll: "{{route("admin.menu.enableAll")}}",
            disableAll: "{{route("admin.menu.disableAll")}}",
            confirmDelete: "{{route("admin.menu.confirm-bulk-delete")}}"
        };

        $('#searchField').keyup(function () {
            table.search($(this).val()).draw();
        });

        //Enables or disables the menu and reload the ajax after success
        $('body').on('click', '.enableDisable', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    location.reload();
                }
            });
        });

        //toggle all checkbox checked or unchecked
        $('body').on('click', 'input[name="checkAll"]', function () {
            var checkBoxes = $("input[name=checkbox\\[\\]]");
            checkBoxes.prop("checked", $(this).prop("checked"));
        });

        //enable selected menus
        $('body').on('click', '#enable', function (e) {
            var url = route_url.enableAll;
            enableDisableMenu(e, url);
        });

        //disable selected menus
        $('body').on('click', '#disable', function (e) {
            var url = route_url.disableAll;
            enableDisableMenu(e, url);
        });

        function enableDisableMenu(e, url) {
            e.preventDefault();
            var formData = $('input[name^=checkbox]');
            var data = {};
            formData.each(function (index) {
                if ($(this).is(':checked')) {
                    data[index] = $(this).val();
                }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: $('meta[name=csrf-token]').attr("content"),
                    id: data
                },
                success: function (response) {
                    if (response == 'ok') {
                        $('body').find('input[type="checkbox"]').prop('checked', false);
                        location.reload();
                    }
                }
            });
        }


        //Delete bulk confirmation popup
        $('body').on('click', '#delete', function () {
            confirmDelete(route_url.confirmDelete);
        });

        function deleteBulkMenu(url) {
            var formData = $('input[name^=checkbox]');

            var data = {};
            formData.each(function (index) {
                if ($(this).is(':checked')) {
                    data[index] = $(this).val();
                }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: $('meta[name=csrf-token]').attr("content"),
                    id: data
                },
                success: function (response) {
                    if (response == 'ok') {
                        $('body').find('input[type="checkbox"]').prop('checked', false);
                        location.reload();
                    }
                    $('.modal').modal('hide');
                }
            });
        }
    </script>

@endsection