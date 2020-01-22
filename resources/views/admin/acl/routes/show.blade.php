@extends('layouts.admin')
@section('page_title', trans($trans_path.'generel.page.show.title'))
@section('page_description', trans($trans_path.'generel.page.show.description'))
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
                    {{ trans($trans_path.'general.content.show') }}
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
                <div class="jarviswidget jarviswidget-color-blueDark" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" id="wid-id-0">
                    <header>
                        <span class="widget-icon">
                            <i class="fa fa-edit">
                            </i>
                        </span>
                        <h2>
                            {{ trans($trans_path.'general.content.show') }}
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
                            {!! Form::model($route, ['route' => 'admin.routes.index', 'method' => 'GET', 'class' => 'smart-form','id'=>"checkout-form"]) !!}
                            
                           @include($view_path.'partials._route_form')

                            {{-- tab end --}}
                            <footer>
                                {!! Form::submit(trans($admin_trans_path.'general.button.close'), ['class' => 'btn btn-primary']) !!}
                                <a class="btn btn-default" href="{!! route('admin.routes.edit', $route->id) !!}" title="{{ trans($admin_trans_path.'general.button.edit') }}">
                                    {{ trans($admin_trans_path.'general.button.edit') }}
                                </a>
                            </footer>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
    <!-- end widget content -->
    <!-- end widget div -->
</div>
@endsection
