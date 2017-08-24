@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Register
@endsection

@section('content')

<body class="hold-transition register-page">
    <div id="app" v-cloak>
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ url('/home') }}"><b>Admin</b>LTE</a>
            </div>

            <div class="register-box-body">
                <p class="login-box-msg">{{ trans('adminlte_lang::message.registermember') }}</p>
                @if (isset($valid) && $valid)
                    <div style="color: green; font-weight: 800;">VALID</div>
                @else
                    <div style="color: red; font-weight: 800;">INVALID</div>
                @endif
                <form action="/authenticator/check2fa" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input name="one_time_password" type="text">

                    <button type="submit">Authenticate</button>
                </form>

            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
    </div>
	
    @include('adminlte::layouts.partials.scripts_auth')

    @include('adminlte::auth.terms')
</body>

@endsection
