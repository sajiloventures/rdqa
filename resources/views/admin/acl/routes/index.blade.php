@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.index.title'))
@section('page_description', trans($trans_path.'general.page.index.description'))
@section('page_specific_styles')
@endsection
@section('content')
<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <h1 class="page-title txt-color-blueDark">
                {{ trans($trans_path.'general.content.list') }}
            </h1>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <span class="pull-right">
                <a class="btn btn-default btn-sm txt-color-blue" href="{!! route('admin.routes.create') !!}" title="{{ trans($trans_path.'general.action.create') }}">
                    <i class="fa fa-lg fa-plus-square">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" data-toggle="modal" data-target="#resetModal" title="{{ trans($trans_path.'general.action.reset-routes') }}">
                    <i class="fa fa-lg fa-gear">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="{!! route('admin.routes.load') !!}" title="{{ trans($trans_path.'general.action.load-routes') }}">
                    <i class="fa fa-lg fa-refresh">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" onclick="document.forms['frmRouteList'].action = '{{ route('admin.routes.enable-selected') }}';  document.forms['frmRouteList'].submit(); return false;" title="{{ trans($trans_path.'general.action.enable-selected') }}">
                    <i class="fa fa-lg fa-check-circle-o">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" onclick="document.forms['frmRouteList'].action = '{{ route('admin.routes.disable-selected') }}';  document.forms['frmRouteList'].submit(); return false;" title="{{ trans($trans_path.'general.action.disable-selected') }}">
                    <i class="fa fa-lg fa-ban">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" onclick="document.forms['frmRouteList'].action = '{{ route('admin.routes.save-perms') }}';  document.forms['frmRouteList'].submit(); return false;" title="{{ trans($trans_path.'general.action.save-perms-assignment') }}">
                    <i class="fa fa-lg fa-floppy-o">
                    </i>
                </a>
            </span>
        </div>
    </div>
    @include('admin.partials._status')
    <!-- widget grid -->
    <section class="" id="widget-grid">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" id="wid-id-0">
                    <header>
                        <span class="widget-icon">
                            <i class="fa fa-random">
                            </i>
                        </span>
                        <h2>
                            {{ trans($trans_path.'general.content.list') }}
                        </h2>
                    </header>
                    <!-- widget div-->
                    <div>
                        <!-- widget content -->
                        <div class="widget-body no-padding">
                            {{--       @component('admin.component.search' ,['url' => 'routes'])
                                    @if(isset($data['name']))
                                        @slot('name')
                                            {{ $data['name'] }}
                                        @endslot
                                    @endif
                                @endcomponent --}}
                                {!! Form::open( array('route' => 'admin.routes.save-perms', 'id' => 'frmRouteList') ) !!}
                            <div class="table-responsive">    
                            <table class="table table-striped table-bordered table-hover table-condensed smart-form has-tickbox" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">
                                            <label class="checkbox table-header-checkbox">
                                                    <input type="checkbox" onclick="toggleCheckbox(); return false;" title="{{ trans($admin_trans_path.'general.button.toggle-select') }}">
                                                                <i></i>
                                            </label>
                                        </th>
                                        <th> 
                                            {{ trans($admin_trans_path.'general.columns.permission') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.method') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.path') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.name') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                     <th style="text-align: center">
                                       <label class="checkbox">
                                            <input type="checkbox" onclick="toggleCheckbox(); return false;" title="{{ trans($admin_trans_path.'general.button.toggle-select') }}">
                                                        <i></i>
                                        </label>
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.permission') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.method') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.path') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.name') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.actions') }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="6">
                                            {!! $routes->render() !!}
                                        </td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($routes as $route)
                                    <tr>
                                        <td >
                                            <label class="checkbox">
                                                {!! Form::checkbox('chkRoute[]', $route->id) !!}
                                                <i></i>
                                            </label>                                            
                                        </td>
                                        <td>
                                            {!! Form::select( 'perms['. $route->id .']', $perms, (isset($route->permission)?$route->permission->id:''), [ 'style' => 'width:310px', 'class' => 'select-perms'] ) !!}
                                        </td>
                                        <td>
                                            {!! link_to_route('admin.routes.show', $route->method, [$route->id], []) !!}
                                        </td>
                                        <td>
                                            {!! link_to_route('admin.routes.show', $route->path, [$route->id], []) !!}
                                        </td>
                                        @if ('' != $route->name)
                                        <td>
                                            {!! link_to_route('admin.routes.show', $route->name, [$route->id], []) !!}
                                        </td>
                                        @else
                                        <td>
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{!! route('admin.routes.edit', $route->id) !!}" title="{{ trans('general.button.edit') }}">
                                                <i class="fa fa-lg fa-fw fa-pencil-square-o">
                                                </i>
                                            </a>
                                            @if($route->enabled )
                                            <a href="{!! route('admin.routes.disable', $route->id) !!}" title="{{ trans('general.button.disable') }}">
                                                <i class="fa fa-lg fa-fw fa-check-circle-o enabled txt-color-greenDark">
                                                </i>
                                            </a>
                                            @else
                                            <a href="{!! route('admin.routes.enable', $route->id) !!}" title="{{ trans('general.button.enable') }}">
                                                <i class="fa fa-lg fa-fw fa-ban disabled txt-color-orange">
                                                </i>
                                            </a>
                                            @endif

                                             @if($route->isDeletableBy() )
                                            <a href="#" onclick="confirmDelete('{!! route('admin.routes.confirm-delete', $route->id) !!}')" title="{{ trans('general.button.delete') }}">
                                                <i class="fa fa-lg fa-fw fa-trash-o deletable txt-color-red">
                                                </i>
                                            </a>
                                            @else
                                            <i class="fa fa-lg fa-fw fa-trash-o text-muted" title="{{ trans($trans_path. 'general.error.cant-delete-this-route') }}">
                                            </i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            {!! Form::close() !!}
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
<!-- Optional bottom section for modals etc... -->
@section('page_specific_scripts')
<script language="JavaScript">
    function toggleCheckbox() {
            checkboxes = document.getElementsByName('chkRoute[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
</script>
<script type="text/javascript">
    $(document).ready(function () {
            $(".select-global-perm").select2();
            $(".select-perms").select2();
        });
</script>
<div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Reset routes</h4>
            </div>
            <div class="modal-body">
                <strong class="text-danger">Are you sure that you want to reset routes?</strong>
                <p>
                    Note: This will remove all routes along with permissions and assigned roles.
                </p>
                This operation is irreversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{!! route('admin.routes.reset') !!}" type="button" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>
{!! Html::script('smartadmin/js/datatable.js') !!}
@endsection
