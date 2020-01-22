@extends('layouts.frontend')

@section('content')

        <div id="content" class="container">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
                    <h1 class="txt-color-red">RDQA</h1>
                    <div class="hero">

                        <div class="pull-left login-desc-box-l">
                            <h4 class="paragraph-header">Routine Data Quality Assessment Tool</h4>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 animated fadeInDown">
                    <div class="well no-padding">
                            <form id="login-form"  class="smart-form client-form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                            <header>
                                Sign In
                            </header>

                            <fieldset>

                                <section>
                                    <label class="label">E-mail</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="email" name="email">
                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-user txt-color-teal"></i>
                                            Please enter email address
                                        </b>
                                    </label>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </section>

                                <section>
                                    <label class="label">Password</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="password">
                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-lock txt-color-teal"></i>
                                            Enter your password
                                        </b>
                                    </label>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif

                                    {{--<div class="note">--}}
                                        {{--<a href="{{ route('password.request') }}">--}}
                                            {{--Forgot Your Password?--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                </section>

                                <section>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <i></i>Stay signed in</label>
                                </section>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </footer>
                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
