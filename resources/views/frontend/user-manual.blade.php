@extends('layouts.frontend')

@section('page_specific_styles')
<style>
    img {
        max-width: 100%;
    }
    .download_button {
        margin-right: -48px;
    }
    @media only screen and (max-width: 768px) {

        .download_button {
            margin-right: -7px;
        }
    }
    @media only screen and (min-width: 1020px) {

        .download_button {
            margin-right: -7px;
        }
    }
    @media only screen and (min-width: 1270px) {

        .download_button {
            margin-right: -48px;
        }
    }
    @media only screen and (min-width: 1360px) {

        .download_button {
            margin-right: -80px;
        }
    }
</style>
@endsection

@section('content')

    <div class="container userManualContainer" lang="ne" style="font-size: 16px;">
        <div class="col-md-12 text-right">
            <a href="javascript:void(0)" class="btn btn-primary showVideo"><i class="fa fa-play"></i> Watch video</a>
            <a href="javascript:void(0)" class="btn btn-danger hideVideo" style="display: none;"><i class="fa fa-remove"></i> Hide video</a>
            <a href="{{ route('downloadManual') }}" class="btn btn-primary download_button" target="_blank"><i class="fa fa-download"></i> Download</a>
        </div>
        <div class="col-md-12">

            <div class="widget-body well no-padding text-center videoDiv margin-top-10" style="margin: auto; display: none;">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://drive.google.com/file/d/1zzigKKnfn4ExU3YPSziL2LukDVAgIwoi/preview"></iframe>
                </div>
            </div>
        </div>
        {!! $data !!}
    </div>
@endsection

@section('page_specific_script')
    <script>
        $('.userManualContainer').on('click', 'a', function (e) {
            var id = $(this).attr('href');
            var selector = $(id);
            if (selector.length) {
                scrollToContainer(selector);
                e.preventDefault();
            }
        });


        $('.showVideo').on('click', function (e) {
            e.preventDefault();
            $('.videoDiv').slideDown();
            $(this).hide();
            $('.hideVideo').show();
        });
        $('.hideVideo').on('click', function (e) {
            e.preventDefault();
            $('.videoDiv').slideUp();
            $(this).hide();
            $('.showVideo').show();
        });

    </script>
@endsection
