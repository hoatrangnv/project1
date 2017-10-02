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

				<div class="qrcode">
					Google QRCode
					<img src="{{ $googleUrl }}" alt="">
				</div>
				<form action="/authenticator" method="post">
					Type your code:
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="text" name="code">
					<input type="submit" value="check">
				</form>
				@if ($valid)
					<div style="color: green; font-weight: 800;">VALID</div>
				@else
					<div style="color: red; font-weight: 800;">INVALID</div>
				@endif
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
    </div>
	
    @include('adminlte::layouts.partials.scripts_auth')

    @include('adminlte::auth.terms')
</body>

@endsection
