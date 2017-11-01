 <?php 
    $url =  URL::to('login');
    $countdownTime = config("app.count_down_time_login");
    header( "refresh:$countdownTime;url=$url" ); 
    ?>

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
                    <span class="fa-stack fa-lg"><i class="fa fa-circle-thin step"></i></span>Activate
                    <i class="fa fa-long-arrow-right"></i>
                    <span class="fa-stack fa-lg"><i class="fa fa-circle step"></i></span>Complete
                </h2>
            </div>
            <div class="login-box-body" style="text-align: center;">
            {{ trans('adminlte_lang::email.active_success')}}
            <a href="{{ URL::to('login') }}"><u>Login</u></a> after <span id="timer">{{ config("app.count_down_time_login") }} secs</span>
            </div>
        </div>
    </div>
    <script>
        var count = {{ config("app.count_down_time_login") }};
        var counter = setInterval(timer,1000);
        
        function timer()
        {
          count=count-1;
          if (count < 0)
          {
             clearInterval(counter);
             return;
          }

         document.getElementById("timer").innerHTML=count + " secs"; // watch for spelling
        }
        
       
    </script>
    </body>
@endsection
