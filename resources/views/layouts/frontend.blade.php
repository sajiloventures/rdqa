<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" id="extr-page">
<head>
    <meta charset="utf-8">
    <title>RDQA</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link href="{{ asset('smartadmin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/font-awesome.min.css') }}" rel="stylesheet">
{{--<link href="{{ asset('css/front-custom-style.css') }}" rel="stylesheet">--}}

<!-- RDQA Styles : Caution! DO NOT change the order -->
    <link href="{{ asset('smartadmin/css/smartadmin-production-plugins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/smartadmin-production.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/smartadmin-skins.min.css') }}" rel="stylesheet">

    <!-- RDQA RTL Support -->
    <link href="{{ asset('smartadmin/css/smartadmin-rtl.min.css') }}" rel="stylesheet">

    <!-- We recommend you use "your_style.css" to override RDQA
         specific styles this will also ensure you retrain your customization with each RDQA update.
    <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    <link href="{{ asset('smartadmin/css/demo.min.css') }}" rel="stylesheet">

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">--}}
<style>
    #extr-page #header #logo {
        margin-top: 5px;
    }
    #scrollTopContainer {
        position: fixed;
        right: 2%;
        bottom: 2%;
        z-index: 99999;
        display: none;
    }
    .icon-bar {
        border: 1px solid !important;
    }
    .navbar-logo img{
        width: 137px;
    }
    nav.navbar {
        margin-bottom: 0;
    }
</style>
    @yield('page_specific_styles')

</head>

<body>
    @include('layouts.partials.header')

    <!-- MAIN CONTENT -->
    <div id="main" role="main">
        @yield('content')
    </div>

    <span id="scrollTopContainer">
        <a href="#" id="scrollToTop" class="btn btn-danger btn-circle"><i class="fa fa-arrow-up"></i></a>
    </span>
<!--================================================== -->
<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script src="{{ asset('smartadmin/js/plugin/pace/pace.min.js') }}"></script>

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
{{--<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
<script> if (!window.jQuery) {
        document.write('<script src="{{ asset('smartadmin/js/libs/jquery-3.2.1.min.js') }}"><\/script>');
    } </script>

{{--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
<script> if (!window.jQuery.ui) {
        document.write('<script src="{{ asset('smartadmin/js/libs/jquery-ui.min.js') }}"><\/script>');
    } </script>

<!-- IMPORTANT: APP CONFIG -->
<script src="{{ asset('smartadmin/js/app.config.js') }}"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

<!-- BOOTSTRAP JS -->
<script src="{{ asset('smartadmin/js/bootstrap/bootstrap.min.js') }}"></script>

<!-- JQUERY VALIDATE -->
<script src="{{ asset('smartadmin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

<!-- JQUERY MASKED INPUT -->
<script src="{{ asset('smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

<!--[if IE 8]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- MAIN APP JS FILE -->
<script src="{{ asset('smartadmin/js/app.min.js') }}"></script>

<script>
    pageSetUp();
    runAllForms();

    $(function () {
        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                }
            },

            // Messages for form validation
            messages: {
                email: {
                    required: 'Please enter your email address',
                    email: 'Please enter a VALID email address'
                },
                password: {
                    required: 'Please enter your password'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });

    $('#scrollToTop').click(function () {
        scrollToContainer();
    });


    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
            document.getElementById("scrollTopContainer").style.display = "block";
        } else {
            document.getElementById("scrollTopContainer").style.display = "none";
        }
    }

    function scrollToContainer(selector) {
        var top = 0;
        if (selector && selector.length)
            top = selector.offset().top - 20;

        $('html,body').animate({
            scrollTop: top
        },1000);
    }
</script>

    @yield('page_specific_script')
    @yield('page_specific_scripts')
</body>
</html>