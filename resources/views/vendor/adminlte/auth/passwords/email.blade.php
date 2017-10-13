@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    {{trans('adminlte_lang::message.passwordreset')}}
@endsection

@section('content')

<body class="login-page">
    <div id="app">

        <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/home') }}"><img src="{{ url('/') }}/img/logo_gold.png"/><b style="margin-left: 5px; vertical-align: middle;">CLP</b></a>
        </div><!-- /.login-logo -->

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="login-box-body">
            <p class="login-box-msg">{{trans('adminlte_lang::message.passwordreset')}}</p>
            <form role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="form-group input-group-sm {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte_lang::message.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
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
                                {{ trans('adminlte_lang::message.sendpassword') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a><br>
            <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>

        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->
    </div>

    @include('adminlte::layouts.partials.scripts_auth')
</body>

@endsection
