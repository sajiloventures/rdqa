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
                <a class="btn btn-default btn-sm txt-color-blue" href="{!! route('admin.users.create') !!}" title="{{ trans($admin_trans_path.'general.button.create') }}">
                    <i class="fa fa-lg fa-plus-square">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" onclick="document.forms['frmUserList'].action = '{{ route('admin.users.enable-selected') }}';  document.forms['frmUserList'].submit(); return false;" title="{{ trans($admin_trans_path.'general.button.enable') }}">
                    <i class="fa fa-lg fa-check-circle-o">
                    </i>
                </a>
                <a class="btn btn-default btn-sm txt-color-blue" href="#" onclick="document.forms['frmUserList'].action = '{{ route('admin.users.disable-selected') }}';  document.forms['frmUserList'].submit(); return false;" title="{{ trans($admin_trans_path.'general.button.disable') }}">
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
                <div class="jarviswidget jarviswidget-color-blueDark" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" id="wid-id-0">
                    <header>
                        <span class="widget-icon">
                            <i class="fa fa-user">
                            </i>
                        </span>
                        <h2>
                            {{ trans($trans_path.'general.content.list') }}
                        </h2>
                    </header>
                    <!-- widget div-->
                    <div>
                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                        </div>
                        <!-- end widget edit box -->
                        <!-- widget content -->
                        <div class="widget-body no-padding">
                            {!! Form::open( array('route' => 'admin.users.enable-selected', 'id' => 'frmUserList') ) !!}
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-condensed smart-form has-tickbox" width="100%">
                                    <thead>
                                        <tr>
                                            <th>

                                                <label class="checkbox table-header-checkbox">
                                                    <input type="checkbox" onclick="toggleCheckbox(); return false;" title="{{ trans($admin_trans_path.'general.button.toggle-select') }}" />
                                                                <i></i>

                                                </label>
                                            </th>
                                            <th>
                                                {{ trans($admin_trans_path.'general.columns.username') }}
                                            </th>
                                            <th>
                                                {{ trans($admin_trans_path.'general.columns.roles') }}
                                            </th>
                                            <th>
                                                <i class="fa fa-fw fa-email txt-color-blue hidden-md hidden-sm hidden-xs">
                                                </i>
                                                {{ trans($admin_trans_path.'general.columns.email') }}
                                            </th>
                                            <th>
                                                {{ trans($admin_trans_path.'general.columns.actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>
                                                <label class="checkbox">
                                                    <input  type="checkbox" onclick="toggleCheckbox(); return false;" title="{{ trans($admin_trans_path.'general.button.toggle-select') }}">
                                                                <i></i>
                                                </label>
                                            </th>
                                            <th>
                                                {{ trans($admin_trans_path.'general.columns.username') }}
                                            </th>
                                            <th>
                                                {{ trans($admin_trans_path.'general.columns.roles') }}
                                            </th>
                                            <th>
                                                {{ trans($admin_trans_path.'general.columns.email') }}
                                            </th>
                                            <th>
                                                {{ trans($admin_trans_path.'general.columns.actions') }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="6">
                                                {!! $users->render() !!}
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                @if ($user->canBeDisabled())
                                                <label class="checkbox">
                                                    {!! Form::checkbox('chkUser[]', $user->id) !!}
                                                    <i>
                                                    </i>
                                                </label>
                                                @endif
                                            </td>
                                            <td>
                                                {!! link_to_route('admin.users.show', $user->username, [$user->id], []) !!}
                                            </td>
                                            <td>
                                                {{ ViewHelper::getRolesExceptUserRole($user->roles) }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                <a href="{!! route('admin.users.impersonate', $user->id) !!}"
                                                   title="{{ trans($admin_trans_path.'general.button.impersonate') }}">
                                                    <i class="fa fa-fw fa-lg fa-user-secret">
                                                    </i>
                                                </a>
                                                @if ( $user->isEditable() )
                                                <a href="{!! route('admin.users.edit', $user->id) !!}" title="{{ trans($admin_trans_path.'general.button.edit') }}">
                                                    <i class="fa fa-fw fa-lg fa-pencil-square-o">
                                                    </i>
                                                </a>
                                                @else
                                                <i class="fa fa-fw fa-lg fa-pencil-square-o text-muted" title="{{ trans($admin_trans_path.'general.error.cant-be-edited') }}">
                                                </i>
                                                @endif

                                              @if ($user->canBeDisabled())
                                              @if ( $user->enabled )
                                                <a class="txt-color-greenDark" href="{!! route('admin.users.disable', $user->id) !!}" title="{{ trans($admin_trans_path.'general.button.disable') }}">
                                                    <i class="fa fa-fw fa-lg fa-check-circle-o enabled">
                                                    </i>
                                                </a>
                                                @else
                                                <a href="{!! route('admin.users.enable', $user->id) !!}" title="{{ trans($admin_trans_path.'general.button.enable') }}">
                                                    <i class="fa fa-fw fa-lg fa-ban disabled">
                                                    </i>
                                                </a>
                                                @endif
                                                @else
                                                <i class="fa fa-fw fa-lg fa-ban text-muted" title="{{ trans($admin_trans_path.'general.error.cant-be-disabled') }}">
                                                </i>
                                                @endif

                                              @if ( $user->isDeletable() )
                                                <a class="txt-color-red" href="#" onclick="confirmDelete('{!! route('admin.users.confirm-delete', $user->id) !!}')" title="{{ trans($admin_trans_path.'general.button.delete') }}">
                                                    <i class="fa fa-fw fa-lg fa-trash-o deletable">
                                                    </i>
                                                </a>
                                                @else
                                                <i class="fa fa-fw fa-lg fa-trash-o text-muted" title="{{ trans($admin_trans_path.'general.error.cant-be-deleted') }}">
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
            checkboxes = document.getElementsByName('chkUser[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
</script>
{!! Html::script('smartadmin/js/datatable.js') !!}
@endsection
