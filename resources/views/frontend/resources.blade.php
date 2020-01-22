@extends('layouts.frontend')

@section('page_specific_styles')
    <style>
        .resourceDescription {
            max-height: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            white-space: nowrap;
            cursor: pointer;
        }
        .downloadButtons a {
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')

    <div class="container" lang="ne">
        <h1> RDQA Resources</h1>
        @php $count = 0; @endphp
        @if(isset($resources))
            <div class="row">
                @foreach($resources as $resource)
                    <div class="col-md-6">
                        <div class="well padding-10">
                            <div class="row">
                                <div class="col-md-9">
                                    <h3 class="no-margin text-danger">
                                        {{ ++$count }}. {{ $resource->name }}
                                    </h3>
                                    <p class="resourceDescription margin-top-10">
                                        {!! $resource->description !!}
                                    </p>
                                </div>
                                @php
                                    $files = [];
                                    if ($resource->files)
                                        $files = explode('~,', $resource->files)
                                @endphp
                                <div class="col-md-3 text-right downloadButtons">
                                    @if(count($files) > 0)
                                        @foreach($files as $file)
                                            @if(File::exists(public_path(config('rdqa.asset_path.resource_file')) . '/' . $file))
                                                <a href="{{ asset(config('rdqa.asset_path.resource_file')) . '/' . $file }}" class="btn btn-primary" download rel="tooltip" data-placement="top" data-original-title="{{ $file }}" style="max-width: 100%; overflow: hidden;"><i class="fa fa-download"></i> Download</a>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>
@endsection

@section('page_specific_script')
    <script>
        $('.resourceDescription').on('click', function () {
            $(this).removeClass("resourceDescription");
        });
    </script>
@endsection