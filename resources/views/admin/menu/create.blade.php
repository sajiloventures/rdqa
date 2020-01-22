@extends('admin.layouts.master')

@section('page_specific_styles')
    <!-- bootstrap switch css -->
    <link rel="stylesheet" href="{{ asset(config('rdqa.asset_path.admin.css').'bootstrap_switch.css') }}">

@endsection

@section('page_specific_scripts')
    <!-- bootstrap switch -->
    <script src="{{ asset(config('rdqa.asset_path.admin.js').'bootstrap_switch.js') }}"></script>
    <script>
        $("input[name='status']").bootstrapSwitch({
            onText: 'Yes',
            offText: 'No'
        });
    </script>


    <script>
        $('.saveCloseButton').click(function (event) {
            checkSlugInServer();
            if (submitFormEnable){
                $('form#menu_add_edit_form').submit();
            }
        });
    </script>

@endsection

@section('top-bar')

    @include($view_path.'.partials.top_nav')

@endsection

@section('content')


    <div class="menu-add-form _mlr20">
        <div class="card m-b-0">
            <div class="row">

                {!! Form::open( ['route' => $base_route.'.store', 'id' => 'menu_add_edit_form', 'class' => 'smart-form']) !!}

                @include($view_path.'.partials._menu_form')
                @include($view_path.'.partials._form_right_side')

                {!! Form::close() !!}

            </div>
        </div>

    </div>

@endsection

