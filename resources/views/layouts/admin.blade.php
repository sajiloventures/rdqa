<!DOCTYPE html>
<html lang="ne">
{{--<html lang="{{ app()->getLocale() }}">--}}
<head>
    <meta charset="utf-8">
    <title>@yield('page_title')</title>
    <meta name="description" content="@yield('page_description')">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- #CSS Links -->
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    {{--<link href="{{ asset('css/all.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('smartadmin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/smartadmin-production-plugins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/smartadmin-production.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/smartadmin-skins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('smartadmin/css/smartadmin-rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
    <!-- We recommend you use "your_style.css" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update.
    <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="/smartadmin/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/smartadmin/img/favicon/favicon.ico" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">--}}

    <!-- #APP SCREEN / ICONS -->
    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="/smartadmin/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/smartadmin/img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/smartadmin/img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/smartadmin/img/splash/touch-icon-ipad-retina.png">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="/smartadmin/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="/smartadmin/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="/smartadmin/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
    <style>
        .smart-form.table .table-header-checkbox {
            margin-bottom: 19px;
        }

        body.smart-style-6 #logo-group > span#logo::before {
            content: "";
        }
        .jarviswidget-color-blueDark .nav-tabs li:not(.active) a, .jarviswidget-color-blueDark > header > .jarviswidget-ctrls a {
            color: #000000 !important;
        }
        .jarviswidget .widget-body table.table {
            background: white;
            width: 100%;
        }
        .jarviswidget .widget-body{
            overflow: auto;
            padding:13px;
        }
        body.smart-style-6 {
            font-family: "Open Sans",Arial,Helvetica,Sans-Serif !important;
        }

        .fc-head-container thead tr, .table thead tr, .jarviswidget > div, body, .bootstrapWizard li .title {
            font-size: 14px;
        }
    </style>

    @yield('page_specific_styles')
</head>

<!--

TABLE OF CONTENTS.

Use search to find needed section.

===================================================================

|  01. #CSS Links                |  all CSS links and file paths  |
|  02. #FAVICONS                 |  Favicon links and file paths  |
|  03. #GOOGLE FONT              |  Google font link              |
|  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
|  05. #BODY                     |  body tag                      |
|  06. #HEADER                   |  header tag                    |
|  07. #PROJECTS                 |  project lists                 |
|  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
|  09. #MOBILE                   |  mobile view dropdown          |
|  10. #SEARCH                   |  search field                  |
|  11. #NAVIGATION               |  left panel & navigation       |
|  12. #MAIN PANEL               |  main panel                    |
|  13. #MAIN CONTENT             |  content holder                |
|  14. #PAGE FOOTER              |  page footer                   |
|  15. #SHORTCUT AREA            |  dropdown shortcuts area       |
|  16. #PLUGINS                  |  all scripts and plugins       |

===================================================================

-->

<!-- #BODY -->
<!-- Possible Classes

    * 'smart-style-{SKIN#}'
    * 'smart-rtl'         - Switch theme mode to RTL
    * 'menu-on-top'       - Switch to top navigation (no DOM change required)
    * 'no-menu'			  - Hides the menu completely
    * 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
    * 'fixed-header'      - Fixes the header
    * 'fixed-navigation'  - Fixes the main menu
    * 'fixed-ribbon'      - Fixes breadcrumb
    * 'fixed-page-footer' - Fixes footer
    * 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
-->
<body class="desktop-detected pace-done smart-style-6">
@include('admin.partials._modal_body')
<!-- #HEADER -->
@include('admin.partials.header')
<!-- END HEADER -->

<!-- #NAVIGATION -->
<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS/SASS variables -->
@include('admin.partials.nav')
<!-- END NAVIGATION -->

<!-- #MAIN PANEL -->
<div id="main" role="main">

    <!-- RIBBON -->
@include('admin.partials.breadcrumb')
<!-- END RIBBON -->
    @yield('content')

</div>
<!-- END #MAIN PANEL -->

<!-- #PAGE FOOTER -->
@include('admin.partials.footer')
<!-- END FOOTER -->

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('smartadmin/js/plugin/pace/pace.min.js') }}"></script>

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
{{--<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
<script>
    if (!window.jQuery) {
        document.write('<script src="{{ asset('smartadmin/js/libs/jquery-3.2.1.min.js') }}"><\/script>');
    }
</script>

{{--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="{{ asset('smartadmin/js/libs/jquery-ui.min.js') }}"><\/script>');
    }
</script>


<!-- IMPORTANT: APP CONFIG -->
<script src="{{ asset('smartadmin/js/app.config.js') }}"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
<script src="{{ asset('smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('smartadmin/js/bootstrap/bootstrap.min.js') }}"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="{{ asset('smartadmin/js/notification/SmartNotification.min.js') }}"></script>

<!-- JARVIS WIDGETS -->
<script src="{{ asset('smartadmin/js/smartwidgets/jarvis.widget.min.js') }}"></script>

<!-- EASY PIE CHARTS -->
<script src="{{ asset('smartadmin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

<!-- SPARKLINES -->
<script src="{{ asset('smartadmin/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

<!-- JQUERY VALIDATE -->
<script src="{{ asset('smartadmin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

<!-- JQUERY MASKED INPUT -->
{{--<script src="{{ asset('smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>--}}

<!-- JQUERY SELECT2 INPUT -->
{{--<script src="{{ asset('smartadmin/js/plugin/select2/select2.min.js') }}"></script>--}}

<!-- JQUERY UI + Bootstrap Slider -->
{{--<script src="{{ asset('smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>--}}

<!-- browser msie issue fix -->
<script src="{{ asset('smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

<!-- FastClick: For mobile devices -->
<script src="{{ asset('smartadmin/js/plugin/fastclick/fastclick.min.js') }}"></script>

<!--[if IE 8]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->


@yield('page_specific_scripts')
<!-- Scripts -->
<script src="{{ asset('smartadmin/js/app.min.js') }}"></script>
{{--<script src="{{ asset('smartadmin/js/all.js') }}"></script>--}}
<script>
    // DO NOT REMOVE : GLOBAL FUNCTIONS!
    $(document).ready(function() {
        pageSetUp();
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
</body>
</html>