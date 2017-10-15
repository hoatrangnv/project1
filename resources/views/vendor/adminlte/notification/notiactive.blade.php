@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    
@endsection

@section('content')
    <body class="hold-transition login-page">
    <div id="app">
        <div class="login-box noti-active">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><img src="{{ url('/') }}/img/logo_gold.png"/><b style="margin-left: 5px; vertical-align: middle;">CLP</b></a>
            </div>
            <div class="signupSteps">
                <h2>
                    <span class="fa-stack fa-lg"><i class="fa fa-circle-thin step"></i></span>Register 
                    <i class="fa fa-long-arrow-right"></i> 
                    <span class="fa-stack fa-lg"><i class="fa fa-circle step"></i></span>Activate
                    <i class="fa fa-long-arrow-right"></i>
                    <span class="fa-stack fa-lg"><i class="fa fa-circle-thin step"></i></span>Complete
                </h2>
            </div>
            <div class="login-box-body">
                <div class="thanks-header">Thank you for creating your account.</div>
                @if($private_sale_end)
                    <div class="thanks-body">Please check your email for confirmation letter.</div>
                    <div class="thanks-footer">Be sure to check your spam box if it does not arrive within a few minutues.</div>
                @endif
                <div class="thanks-login"><a href="/login">Go to login.</a></div>
            </div>
        </div>
    </div>
    </body>
@endsection
