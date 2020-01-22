
<header id="header" class="hidden-xs hidden-sm">

    <div id="logo-group">
        <span id="logo">
            <a href="/">
                <img src="{{ asset('smartadmin/logo.png') }}" alt="RDQA" />
            </a>
        </span>
    </div>

    @if(auth()->check())
        <span id="extr-page-header-space">
            <a href="{{ route('logout') }}" class="btn btn-danger">SIGN OUT</a>
        </span>
        <span id="extr-page-header-space">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-default">{{ auth()->user()->fullName }}</a>
        </span>
    @else
        <span id="extr-page-header-space">
            <a href="{{ route('login') }}" class="btn btn-danger">SIGN IN</a>
        </span>
    @endif
    <span id="extr-page-header-space">
        <a href="{{ route('userManual') }}" class="btn btn-danger">Manual</a>
    </span>
    <span id="extr-page-header-space">
        <a href="{{ route('faq') }}" class="btn btn-danger">FAQ</a>
    </span>
    <span id="extr-page-header-space">
        <a href="{{ route('resources') }}" class="btn btn-danger">Resources</a>
    </span>
    <span id="extr-page-header-space">
        <a href="{{ route('view-detail') }}" class="btn btn-danger">View detail</a>
    </span>
</header>
<div class="main-header hidden-md hidden-lg visible-xs visible-sm">
    <div class="container">
        <nav class="navbar">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-logo" href="/" title=""><img src="{{ asset('smartadmin/logo.png') }}" alt="RDQA" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" style="width: auto;">
                    <li>
                        <a href="{{ route('resources') }}" class="text-danger">Resources</a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}" class="text-danger">FAQ</a>
                    </li>
                    <li>
                        <a href="{{ route('userManual') }}" class="text-danger">Manual</a>
                    </li>
                    @if(auth()->check())
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="text-danger">{{ auth()->user()->fullName }}</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="text-danger btn btn-danger">SIGN OUT</a>
                    </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="text-danger btn btn-danger">SIGN IN</a>
                        </li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse --><!-- /.container-fluid -->
        </nav>
    </div>
</div>