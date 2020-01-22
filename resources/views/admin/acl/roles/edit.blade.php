@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.edit.title'))
@section('page_description', trans($trans_path.'general.page.edit.description'))
@section('page_specific_styles')
@endsection
@section('content')
<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa-fw fa fa-home">
                </i>
                <span>
                     {{ trans($trans_path.'general.content.update') }}
                </span>
            </h1>
        </div>
    </div>
 <!-- Show any messages if exist below breadcrumb -->
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
                            <i class="fa fa-edit">
                            </i>
                        </span>
                        <h2>
                                   {{ trans($trans_path.'general.content.update') }}
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
                           {!! Form::model( $role, ['route' => ['admin.roles.update', $role->id], 'method' => 'POST','class' => 'smart-form', 'id' => 'form_edit_role'] ) !!}
                           
                           @include($view_path.'.partials._role_form')

                              
                        {{-- tab end --}}
                            <footer>
                                {!! Form::submit( trans($admin_trans_path.'general.button.update'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                                <a class="btn btn-default" href="{!! route('admin.users.index') !!}" title="{{ trans($admin_trans_path.'general.button.cancel') }}">
                                    {{ trans($admin_trans_path.'general.button.cancel') }}
                                </a>
                            </footer>
                            {!! Form::close() !!}
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
<!-- end widget content -->
<!-- end widget div -->
@endsection

@section('page_specific_scripts')
    <!-- extra script -->
    @include($view_path.'.partials.scripts')
    <script>
        $(document).ready(function () {
            recursiveTravelParentToChild($('ul[role="tree"]').find('li[class="parent_li"]:first'));
        });
    </script>

    <!-- Select2 js -->
    @include($view_path.'.partials._body_bottom_select2_js_user_search')
    <!-- form submit -->
    @include($view_path.'.partials._body_bottom_submit_role_edit_form_js')
@endsection
