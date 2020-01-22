@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.index.title'))
@section('page_description', trans($trans_path.'general.page.index.title'))
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
                <a class="btn btn-default btn-sm txt-color-blue" href="{!! route('admin.permissions.create') !!}" title="{{ trans($trans_path. 'general.action.create') }}">
                    <i class="fa fa-lg fa-plus-square">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="{!! route('admin.permissions.reset') !!}" title="{{ trans($trans_path. 'general.action.reset') }}">
                    <i class="fa fa-lg fa-cogs">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="{!! route('admin.permissions.generate') !!}" title="{{ trans($trans_path. 'general.action.generate') }}">
                    <i class="fa fa-lg fa-refresh">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" onclick="document.forms['frmPermList'].action = '{!! route('admin.permissions.enable-selected') !!}';  document.forms['frmPermList'].submit(); return false;" title="{{ trans($admin_trans_path.'general.button.enable') }}">
                    <i class="fa fa-lg fa-check-circle-o">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" onclick="document.forms['frmPermList'].action = '{!! route('admin.permissions.disable-selected') !!}';  document.forms['frmPermList'].submit(); return false;" title="{{ trans($admin_trans_path.'general.button.disable') }}">
                    <i class="fa fa-lg fa-ban">
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
                <div class="jarviswidget jarviswidget-color-blueDark"
                     data-widget-editbutton="false"
                     data-widget-colorbutton="false"
                     data-widget-fullscreenbutton="false"
                     data-widget-togglebutton="false"
                     data-widget-deletebutton="false"
                     id="wid-id-0">
                    <header>
                        <span class="widget-icon">
                            <i class="fa fa-unlock-alt">
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
                          
                            {!! Form::open( array('route' => 'admin.permissions.enable-selected', 'id' => 'frmPermList') ) !!}
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
                                            {{ trans($admin_trans_path.'general.columns.display_name') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.description') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.routes') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.roles') }}
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
                                            {{ trans($admin_trans_path.'general.columns.display_name') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.description') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.routes') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.roles') }}
                                        </th>
                                        <th>
                                            {{ trans($admin_trans_path.'general.columns.actions') }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="6">
                                            {!! $perms->render() !!}
                                        </td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($perms as $perm)
                                    <tr>
                                       <td style="text-align: center">
                                       <label class="checkbox">
                                             {!! Form::checkbox('chkPerm[]', $perm->id); !!}
                                             <i></i>
                                        </label>
                                        </td>
                                        <td>
                                            {!! link_to_route('admin.permissions.show', $perm->display_name, [$perm->id], []) !!}
                                        </td>
                                        <td>
                                            {!! link_to_route('admin.permissions.show', $perm->description, [$perm->id], []) !!}
                                        </td>
                                        <td>
                                            {{ $perm->routes->count() }}
                                        </td>
                                        <td>
                                            {{ $perm->roles->count() }}
                                        </td>
                                        <td>
                                            @if ( $perm->isEditable() )
                                            <a href="{!! route('admin.permissions.edit', $perm->id) !!}" title="{{ trans($admin_trans_path.'general.button.edit') }}">
                                                <i class="fa fa-lg fa-fw fa-pencil-square-o">
                                                </i>
                                            </a>
                                            @else
                                            <i class="fa fa-lg fa-fw fa-pencil-square-o text-muted" title="{{ trans($trans_path. 'general.error.cant-edit-this-permission') }}">
                                            </i>
                                            @endif

                                            @if ( $perm->enabled )
                                            <a href="{!! route('admin.permissions.disable', $perm->id) !!}" title="{{ trans($admin_trans_path.'general.button.disable') }}">
                                                <i class="fa fa-lg fa-fw fa-check-circle-o enabled txt-color-greenDark">
                                                </i>
                                            </a>
                                            @else
                                            <a href="{!! route('admin.permissions.enable', $perm->id) !!}" title="{{ trans($admin_trans_path.'general.button.enable') }}">
                                                <i class="fa fa-lg fa-fw fa-ban disabled txt-color-orange">
                                                </i>
                                            </a>
                                            @endif

                                            @if ( $perm->isDeletable() )
                                            <a href="#" onclick="confirmDelete('{!! route('admin.permissions.confirm-delete', $perm->id) !!}')" title="{{ trans($admin_trans_path. 'general.button.delete') }}">
                                                <i class="fa fa-lg fa-fw fa-trash-o deletable">
                                                </i>
                                            </a>
                                            @else
                                            <i class="fa fa-lg fa-fw fa-trash-o text-muted" title="{{ trans($trans_path. 'general.error.cant-delete-perm-in-use') }}">
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
            checkboxes = document.getElementsByName('chkPerm[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
</script>
{!! Html::script('smartadmin/js/datatable.js') !!}
@endsection
