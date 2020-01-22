@extends('layouts.admin')
@section('page_title', $text['title'])
@section('page_description', $text['description'])
@section('content')
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center error-box">
                        <h1 class="error-text tada animated"><i class="fa fa-times-circle text-danger error-icon-shadow"></i> {{ $text['code'] }} </h1>
                        <h2 class="font-xl"><strong>{{ $text['title'] }}</strong></h2>
                        <br />
                        <p class="lead semi-bold">

                            <small>
                                {!! $text['description'] !!}
                            </small>
                        </p>
                        <ul class="error-search text-left font-md">
                            <li><a href="{{ route('admin.home') }}"><small>Go to My Dashboard <i class="fa fa-arrow-right"></i></small></a></li>
                            <li><a href="{{ URL::previous() }}"><small>Go back</small></a></li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection