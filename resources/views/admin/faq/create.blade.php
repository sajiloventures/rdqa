@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.create.title'))
@section('page_description', trans($trans_path.'general.page.create.description'))
@section('page_specific_styles')
    <style>
        .smart-form section {
            margin-bottom: 25px;
        }
    </style>
@endsection

@section('content')
    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-home">
                    </i>
                    <span>
                    {{ trans($trans_path.'general.content.add') }}
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
                            <i class="fa fa-user-plus">
                            </i>
                        </span>
                            <h2>
                                {{ trans($trans_path.'general.content.add') }}
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
                                {!! Form::open( ['route' => 'admin.faq.store', 'id' => 'form_edit_faq','class' => 'smart-form'] ) !!}

                                @include($view_path.'.partials._faq_form')


                                {{-- tab end --}}
                                <div class="smart-form">
                                    <footer>
                                        {!! Form::button( trans($admin_trans_path.'general.button.create'), ['class' => 'btn btn-primary', 'type' => 'submit'] ) !!}
                                        <a class="btn btn-default" href="{!! route('admin.faq') !!}" title="{{ trans($admin_trans_path.'general.button.cancel') }}">
                                            {{ trans($admin_trans_path.'general.button.cancel') }}
                                        </a>
                                    </footer>
                                </div>
                                {!! Form::close() !!}
                            </div>
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
    @include($view_path . '.partials.common_script')
@endsection