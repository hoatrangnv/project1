@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Password reset
@endsection

@section('content')

    <body class="login-page">

    <div id="app">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><img src="{{ url('/') }}/img/logo_gold.png"/><b style="margin-left: 5px; vertical-align: middle;">CLP</b></a>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="login-box-body">
                <p class="login-box-msg">{{ trans('adminlte_lang::message.passwordreset') }}</p>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group input-group-sm has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" placeholder="{{ trans('adminlte_lang::user.email') }}" name="email" value="{{ old('email') }}" class="form-control">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <div class="form-group input-group-sm has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" placeholder="Password" name="password" class="form-control">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            {{ $errors->first('password') }}
                         </span>
                    @endif
                </div>
                <div class="form-group input-group-sm has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input type="password" placeholder="Retype password" name="password_confirmation" class="form-control">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            {{ $errors->first('password_confirmation') }}
                        </span>
                    @endif
                </div>
                    @if (Config::get('app.enable_captcha'))
                        <div class="form-group">
                            {!! app('captcha')->display()!!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
						        {{ $errors->first('g-recaptcha-response') }}
					        </span>
                            @endif
                        </div>
                    @endif
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </div>
                </form>
                <a href="{{ url('/login') }}">Log in</a><br>
                <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.membership') }}</a>
            </div>
        </div>
    </div>

    @include('adminlte::layouts.partials.scripts_auth')
    </body>

@endsection
