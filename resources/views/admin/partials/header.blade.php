<header id="header">
    <div id="logo-group">

        <!-- PLACE YOUR LOGO HERE -->
        <span id="logo"> <img src="{{ asset('smartadmin/logo.png') }}" alt="RDQA" style="display: block; position: absolute; position: absolute;top: 2%; height: 95%; width: auto;"> </span>
        {{--<a href="{{ route('admin.dashboard') }}"> {{ AppHelper::getConfigValue('COMPANY_NAME') }} </a>--}}

        <!-- END LOGO PLACEHOLDER -->


    </div>

    <!-- #TOGGLE LAYOUT BUTTONS -->
    <!-- pulled right: nav area -->
    <div class="pull-right">

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
            <span> <a href="{{ route('logout') }}" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->

        <!-- search mobile button (this is hidden till mobile view port) -->
        <div id="search-mobile" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
        </div>
        <!-- end search mobile button -->

        {{--<!-- #SEARCH -->--}}
        {{--<!-- input: search field -->--}}
        {{--<form action="#ajax/search.html" class="header-search pull-right">--}}
            {{--<input id="search-fld" type="text" name="param" placeholder="Find reports and more">--}}
            {{--<button type="submit">--}}
                {{--<i class="fa fa-search"></i>--}}
            {{--</button>--}}
            {{--<a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>--}}
        {{--</form>--}}
        {{--<!-- end input: search field -->--}}

        <!-- fullscreen button -->
        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
        </div>
        <!-- end fullscreen button -->

        {{--<!-- multiple lang dropdown : find all flags in the flags page -->--}}
        {{--<ul class="header-dropdown-list hidden-xs">--}}

            {{--<li>--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="/smartadmin/img/blank.gif" class="flag flag-us" alt="United States"> <span> US</span> <i class="fa fa-angle-down"></i> </a>--}}
                {{--<ul class="dropdown-menu pull-right">--}}
                    {{--<li class="active">--}}
                        {{--<a href="javascript:void(0);"><img src="/smartadmin/img/blank.gif" class="flag flag-us" alt="United States"> English (US)</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="javascript:void(0);"><img src="/smartadmin/img/blank.gif" class="flag flag-fr" alt="France"> Français</a>--}}
                    {{--</li>--}}


                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}
        {{--<!-- end multiple lang -->--}}

    </div>
    <!-- end pulled right: nav area -->

</header>
