<!DOCTYPE html>
<html lang="en-us" class="smart-style-6">
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

    <title>Error </title>
    <meta name="description" content="gymfinite error">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
{!! Html::style('smartadmin/css/all.css') !!}

<!-- FAVICONS -->
    <link rel="shortcut icon" href="/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/img/favicon/favicon.ico" type="image/x-icon">

    <!-- GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/splash/touch-icon-ipad-retina.png">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="/img/splash/ipad-landscape.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="/img/splash/ipad-portrait.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

    <style>
        .error-text-2 {
            text-align: center;
            font-size: 700%;
            font-weight: bold;
            font-weight: 100;
            color: #333;
            line-height: 1;
            letter-spacing: -.05em;
            background-image: -webkit-linear-gradient(92deg, #333, #ed1c24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .particle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 1rem;
            height: 1rem;
            border-radius: 100%;
            background-color: #ed1c24;
            background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, .3) 75%, rgba(0, 0, 0, 0));
            box-shadow: inset 0 0 1px 1px rgba(0, 0, 0, .25);
        }

        .particle--a {
            -webkit-animation: particle-a 1.4s infinite linear;
            -moz-animation: particle-a 1.4s infinite linear;
            -o-animation: particle-a 1.4s infinite linear;
            animation: particle-a 1.4s infinite linear;
        }

        .particle--b {
            -webkit-animation: particle-b 1.3s infinite linear;
            -moz-animation: particle-b 1.3s infinite linear;
            -o-animation: particle-b 1.3s infinite linear;
            animation: particle-b 1.3s infinite linear;
            background-color: #00A300;
        }

        .particle--c {
            -webkit-animation: particle-c 1.5s infinite linear;
            -moz-animation: particle-c 1.5s infinite linear;
            -o-animation: particle-c 1.5s infinite linear;
            animation: particle-c 1.5s infinite linear;
            background-color: #57889C;
        }

        @-webkit-keyframes particle-a {
            0% {
                -webkit-transform: translate3D(-3rem, -3rem, 0);
                z-index: 1;
                -webkit-animation-timing-function: ease-in-out;
            }
            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                -webkit-transform: translate3D(4rem, 3rem, 0);
                opacity: 1;
                z-index: 1;
                -webkit-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .75rem;
                height: .75rem;
                opacity: .5;
            }

            100% {
                -webkit-transform: translate3D(-3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-moz-keyframes particle-a {
            0% {
                -moz-transform: translate3D(-3rem, -3rem, 0);
                z-index: 1;
                -moz-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                -moz-transform: translate3D(4rem, 3rem, 0);
                opacity: 1;
                z-index: 1;
                -moz-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .75rem;
                height: .75rem;
                opacity: .5;
            }

            100% {
                -moz-transform: translate3D(-3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-o-keyframes particle-a {
            0% {
                -o-transform: translate3D(-3rem, -3rem, 0);
                z-index: 1;
                -o-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                -o-transform: translate3D(4rem, 3rem, 0);
                opacity: 1;
                z-index: 1;
                -o-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .75rem;
                height: .75rem;
                opacity: .5;
            }

            100% {
                -o-transform: translate3D(-3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @keyframes particle-a {
            0% {
                transform: translate3D(-3rem, -3rem, 0);
                z-index: 1;
                animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                transform: translate3D(4rem, 3rem, 0);
                opacity: 1;
                z-index: 1;
                animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .75rem;
                height: .75rem;
                opacity: .5;
            }

            100% {
                transform: translate3D(-3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-webkit-keyframes particle-b {
            0% {
                -webkit-transform: translate3D(3rem, -3rem, 0);
                z-index: 1;
                -webkit-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                -webkit-transform: translate3D(-3rem, 3.5rem, 0);
                opacity: 1;
                z-index: 1;
                -webkit-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                -webkit-transform: translate3D(3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-moz-keyframes particle-b {
            0% {
                -moz-transform: translate3D(3rem, -3rem, 0);
                z-index: 1;
                -moz-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                -moz-transform: translate3D(-3rem, 3.5rem, 0);
                opacity: 1;
                z-index: 1;
                -moz-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                -moz-transform: translate3D(3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-o-keyframes particle-b {
            0% {
                -o-transform: translate3D(3rem, -3rem, 0);
                z-index: 1;
                -o-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                -o-transform: translate3D(-3rem, 3.5rem, 0);
                opacity: 1;
                z-index: 1;
                -o-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                -o-transform: translate3D(3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @keyframes particle-b {
            0% {
                transform: translate3D(3rem, -3rem, 0);
                z-index: 1;
                animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.5rem;
                height: 1.5rem;
            }

            50% {
                transform: translate3D(-3rem, 3.5rem, 0);
                opacity: 1;
                z-index: 1;
                animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                transform: translate3D(3rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-webkit-keyframes particle-c {
            0% {
                -webkit-transform: translate3D(-1rem, -3rem, 0);
                z-index: 1;
                -webkit-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.3rem;
                height: 1.3rem;
            }

            50% {
                -webkit-transform: translate3D(2rem, 2.5rem, 0);
                opacity: 1;
                z-index: 1;
                -webkit-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                -webkit-transform: translate3D(-1rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-moz-keyframes particle-c {
            0% {
                -moz-transform: translate3D(-1rem, -3rem, 0);
                z-index: 1;
                -moz-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.3rem;
                height: 1.3rem;
            }

            50% {
                -moz-transform: translate3D(2rem, 2.5rem, 0);
                opacity: 1;
                z-index: 1;
                -moz-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                -moz-transform: translate3D(-1rem, -3rem, 0);
                z-index: -1;
            }
        }

        @-o-keyframes particle-c {
            0% {
                -o-transform: translate3D(-1rem, -3rem, 0);
                z-index: 1;
                -o-animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.3rem;
                height: 1.3rem;
            }

            50% {
                -o-transform: translate3D(2rem, 2.5rem, 0);
                opacity: 1;
                z-index: 1;
                -o-animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                -o-transform: translate3D(-1rem, -3rem, 0);
                z-index: -1;
            }
        }

        @keyframes particle-c {
            0% {
                transform: translate3D(-1rem, -3rem, 0);
                z-index: 1;
                animation-timing-function: ease-in-out;
            }

            25% {
                width: 1.3rem;
                height: 1.3rem;
            }

            50% {
                transform: translate3D(2rem, 2.5rem, 0);
                opacity: 1;
                z-index: 1;
                animation-timing-function: ease-in-out;
            }

            55% {
                z-index: -1;
            }

            75% {
                width: .5rem;
                height: .5rem;
                opacity: .5;
            }

            100% {
                transform: translate3D(-1rem, -3rem, 0);
                z-index: -1;
            }
        }
    </style>

    <!--[if IE 9]>
    <style>
        .error-text {
            color: #333 !important;
        }

        .particle {
            display: none;
        }
    </style>
    <![endif]-->
</head>

<body class="desktop-detected pace-done fixed-header smart-style-6">

<!-- MAIN PANEL -->
<!-- MAIN CONTENT -->
<div id="content">

    <!-- row -->
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center error-box">
                        <h1 class="error-text-2 bounceInDown animated">Opps<span
                                    class="particle particle--c"></span><span class="particle particle--a"></span>
                        <span  class="particle particle--b"></span></h1>
                        <a href="{{ URL::previous() }}" class="btn btn-labeled btn-default"> <span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Go Back </a>
                        <h2 class="font-xl"><strong><i class="fa fa-fw fa-warning fa-lg text-warning"></i> Page
                                <u>Something</u> Error</strong>

                                </h2>
<div class="well well-lg alert alert-danger fade in">
                                <i class="fa-fw fa fa-times"></i>
                                <strong>Error!</strong> <?php print_r($e->getMessage());?>
                            </div>
                        <br/>
                        <p class="lead">
                            The page you requested could not be found, either contact your webmaster or try again.<br>
                             Use <b>Go Back</b> button to navigate to the page you have previously come from
                        </p>
                        <p class="font-md">
                            <b>... That didn't work on you? Dang. May you send a feedback, then?</b>
                        </p>
                        <br>
                        <div class="well well-lg ">

                            {{ Form::open(['url'=>'/feedback']) }}
                            {{ Form::textarea('message',null,['class'=>'form-control','style'=>'height:160px;','placeholder'=>'What were you were doing before you saw this page?'])}}
                            <input type="hidden" name="fullurl" value="{{ Request::fullUrl()}}">
                            <div style="padding-top:.5em;">
                                {{ Form::submit('Send feedback',['class'=>'btn btn-primary btn-fill'])}}
                            </div>
                            {{ Form::close() }}

                        </div>

                        <div class="row">

                            <div class="col-sm-12">
                                <ul class="list-inline">
                                    <li>
                                        &nbsp;<a href="{{ url('/')}}">Home</a>&nbsp;
                                    </li>
                                    <li>
                                        .
                                    </li>
                                    <li>
                                        &nbsp;<a href="{{ url('/admin-login')}}">Log-in</a>&nbsp;
                                    </li>
                                    <li>
                                        .
                                    </li>
                                    <li>
                                        &nbsp;<a href="{{ url('/faq')}}">FAQ</a>&nbsp;
                                    </li>
                                    <li>
                                        .
                                    </li>

                                </ul>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- end row -->

    </div>


    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->
<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery) {
        document.write("{{-- Html::script('smartadmin/js/jquery.js') --}}");
    }

</script>
{!! Html::script('smartadmin/js/all.js') !!}
{!! Html::script('assets/js/site.js') !!}
