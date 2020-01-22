@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.index.title'))
@section('page_description', trans($trans_path.'general.page.index.description'))
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
                <a class="btn btn-default btn-sm txt-color-blue" href="{!! route('admin.roles.create') !!}"
                   title="{{ trans($admin_trans_path.'general.button.create') }}">
                    <i class="fa fa-lg fa-plus-square"></i>
                </a>
                &nbsp;
                <a class="btn btn-default btn-sm txt-color-blue" href="#"
                   onclick="document.forms['frmRoleList'].action = '{!! route('admin.roles.enable-selected') !!}';  document.forms['frmRoleList'].submit(); return false;"
                   title="{{ trans($admin_trans_path.'general.button.enable') }}">
                    <i class="fa fa-lg fa-check-circle-o"></i>
                </a>
                &nbsp;
                <a class="btn btn-default btn-sm txt-color-blue" href="#"
                   onclick="document.forms['frmRoleList'].action = '{!! route('admin.roles.disable-selected') !!}';  document.forms['frmRoleList'].submit(); return false;"
                   title="{{ trans($admin_trans_path.'general.button.disable') }}">
                    <i class="fa fa-lg fa-ban"></i>
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
                            <span class="widget-icon"> <i class="fa fa-user-secret"></i> </span>
                            <h2>{{ trans($trans_path.'general.content.list') }} </h2>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                {!! Form::open( array('route' => 'admin.roles.enable-selected', 'id' => 'frmRoleList') ) !!}
                            <div class="table-responsive">    
                            <table class="table table-striped table-bordered table-hover table-condensed smart-form has-tickbox" width="100%">
                                    <thead>
                                    <tr>
                                       <th >
                                            <label class="checkbox table-header-checkbox">
                                                    <input type="checkbox" onclick="toggleCheckbox(); return false;" title="{{ trans($admin_trans_path.'general.button.toggle-select') }}">
                                                                <i></i>
                                            </label>
                                        </th>
                                        <th>{{ trans($admin_trans_path.'general.columns.name') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.display_name') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.description') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.permissions') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.users') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th >
                                            <label class="checkbox ">
                                                <input type="checkbox" onclick="toggleCheckbox(); return false;" title="{{ trans($admin_trans_path.'general.button.toggle-select') }}">
                                                <i></i>
                                            </label>
                                        </th>
                                        <th>{{ trans($admin_trans_path.'general.columns.name') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.display_name') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.description') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.permissions') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.users') }}</th>
                                        <th>{{ trans($admin_trans_path.'general.columns.actions') }}</th>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="6">{!! $roles->render() !!}</td>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td style="text-align: center">
                                           <label class="checkbox">
                                                 {!! Form::checkbox('chkRole[]', $role->id) !!}
                                                 <i></i>
                                            </label>
                                            </td>
                                            <td>{!! link_to_route('admin.roles.show', strtoupper($role->name), [$role->id], []) !!}</td>
                                            <td>{!! link_to_route('admin.roles.show', $role->display_name, [$role->id], []) !!}</td>
                                            <td>{{ $role->description }}</td>
                                            <td>{{ $role->perms->count() }}</td>
                                            <td>{{ $role->users->count() }}</td>
                                            <td>
                                                @if ( $role->isEditable() || $role->canChangePermissions() )
                                                    <a href="{!! route('admin.roles.edit', $role->id) !!}"
                                                       title="{{ trans('general.button.edit') }}"><i
                                                                class="fa fa-fw fa-lg fa-pencil-square-o"></i></a>
                                                @else
                                                    <i class="fa fa-fw fa-lg fa-pencil-square-o text-muted"
                                                       title="{{ trans($admin_trans_path.'general.error.cant-edit-this-role') }}"></i>
                                                @endif

                                                @if ( $role->enabled )
                                                    <a href="{!! route('admin.roles.disable', $role->id) !!}"
                                                       title="{{ trans('general.button.disable') }}"><i
                                                                class="fa fa-fw fa-lg fa-check-circle-o enabled txt-color-greenDark"></i></a>
                                                @else
                                                    <a href="{!! route('admin.roles.enable', $role->id) !!}"
                                                       title="{{ trans('general.button.enable') }}"><i
                                                                class="fa fa-fw fa-lg fa-ban disabled txt-color-orange"></i></a>
                                                @endif

                                                @if ( $role->isDeletable() )

                                                    <a href="#"
                                                       onclick="confirmDelete('{!! route('admin.roles.confirm-delete', $role->id) !!}')"
                                                       title="{{ trans('general.button.delete') }}"><i
                                                                class="fa fa-fw fa-lg fa-trash-o deletable"></i></a>
                                                    </a>
                                                @else
                                                    <i class="fa fa-fw fa-lg fa-trash-o text-muted"
                                                       title="{{ trans($admin_trans_path.'general.error.cant-delete-this-role') }}"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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

<!-- Optional bottom section for modals etc... -->

@section('page_specific_scripts')
    <script language="JavaScript">
        function toggleCheckbox() {
            checkboxes = document.getElementsByName('chkRole[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
    </script>
    {!! Html::script('smartadmin/js/datatable.js') !!}
@endsection




