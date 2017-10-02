@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Register
@endsection

@section('content')

<body class="hold-transition register-page">
    <div id="app" v-cloak>
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ url('/home') }}"><b>CLP</b></a>
            </div>

            <div class="register-box-body">
                <form action="/authenticator" method="post">
                {{ trans("adminlte_lang::home.type_your_code")}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" name="code">
                @if ($valid)
                        <div style="color: green; font-weight: 800;margin-left: 110px;">{{ trans("adminlte_lang::home.valid") }}</div>
                @else
                        <div style="color: red; font-weight: 800;margin-left: 110px;">{{ trans("adminlte_lang::home.in_valid") }}</div>
                @endif
                <input type="submit" class="btn btn-default" value="CHECK">
                </form>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
    </div>
	
    @include('adminlte::layouts.partials.scripts_auth')

    @include('adminlte::auth.terms')
</body>

@endsection
