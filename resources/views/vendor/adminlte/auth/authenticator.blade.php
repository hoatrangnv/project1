@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Authentication
@endsection

@section('content')

<body class="hold-transition register-page">
    <div id="app" v-cloak>
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ url('/home') }}"><img src="{{ url('/') }}/img/logo_gold.png"/><b style="margin-left: 5px; vertical-align: middle;">CLP</b></a>
            </div>

            <div class="register-box-body">
                <form action="/authenticator" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group input-group-sm has-feedback{{ $valid ? '' : ' has-error' }}">
                    <input type="text" value="" name="code" id="code" class="form-control" placeholder="{{ trans("adminlte_lang::home.type_your_code")}}">
                    @if (!$valid)
                        <span class="help-block">
                            {{ trans("adminlte_lang::home.in_valid") }}
                        </span>
                    @endif
                </div>
                <div class="row">
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::default.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
    </div>
	
    @include('adminlte::layouts.partials.scripts_auth')

    @include('adminlte::auth.terms')
</body>

@endsection
