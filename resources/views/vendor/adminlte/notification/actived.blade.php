@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    
@endsection

@section('content')
    <body class="hold-transition login-page">
    <div id="app">
        <div class="login-box" style="width: 580px;">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><img src="{{ url('/') }}/img/logo_gold.png"/><b style="margin-left: 5px; vertical-align: middle;">CLP</b></a>
            </div>
            <div class="login-box-body">
            {{ trans('adminlte_lang::email.active_already')}}
            </div>
        </div>
    </div>
    </body>
@endsection
