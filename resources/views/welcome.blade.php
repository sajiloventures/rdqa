@extends('layouts.frontend')

@section('page_specific_styles')
    <style>
        .nepal_logo {
            max-width: 12%;
        }
        .measure_logo {
            max-width: 20%;
        }
        @media only screen and (max-width: 768px) {

            .nepal_logo, .measure_logo {
                max-width: 50%;
            }
        }
    </style>
@endsection

@section('content')
    @include('admin.partials._status')
    <div class="content">
        <div class="col-md-6">
            <div class="text-center" lang="ne">
                <img src="{{ asset('images/nepal_logo.jpg') }}" class="nepal_logo" />
                <p class="txt-color-red">नेपाल सरकार
                    <br />
                    स्वास्थ्य तथा जनसंख्या मन्त्रालय</p>
                <br />
                <h1 style="text-align: center; font-size: 35px;" class="text-info">
                    <span>नियमित तथ्याङ्क गुणस्तर परीक्षण प्रणाली</span>
                    <br />
                    Routine Data Quality Assessment System
                </h1>
                <br />
                <div class="" style="font-size: 20px; color: black;">
                    <span>
                        सूचना प्रणालीबाट आउने तथ्याङ्कहरुको गुणस्तर परीक्षण गर्न र समग्र सूचना प्रणाली ब्यवस्थापनको अनुगमन तथा मूल्याङ्कनको संरचना, सूचकहरुको परिभाषा, अभिलेख तथा प्रतिबेदनको निर्देशिका, अभिलेख तथा प्रतिबेदन सामाग्री, तथ्याङ्क ब्यवस्थापन प्रक्रिया एवम तथ्याङ्कको प्रयोग जस्ता बिबिध पक्षहरुको मापन गरी सुधारका कार्यक्रमहरु अगाडि बढाउन नियमित तथ्याङ्क परिक्षण प्रणाली प्रयोग गरिन्छ।
                    </span>
                </div>
                <h1>&nbsp;</h1>
                <p style="text-transform: uppercase;">
                    Adapted from: <br />
                    <a href="https://www.measureevaluation.org/resources/publications/ms-17-117" target="_blank">
                        <img src="{{ asset('images/measure_logo.png') }}" class="measure_logo" />
                    </a>
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <p class="hidden-xs hidden-sm">&nbsp;</p>
            <p class="hidden-xs hidden-sm">&nbsp;</p>
            <p class="hidden-xs hidden-sm">&nbsp;</p>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://drive.google.com/file/d/1fVp7Lb2YGbOOz5f1X8-DnWRU0TWRm_3c/preview"></iframe>
            </div>

            {{--<iframe width="100%" height="auto" src="https://drive.google.com/file/d/1fVp7Lb2YGbOOz5f1X8-DnWRU0TWRm_3c/preview"></iframe>--}}
        </div>
    </div>
@endsection
