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
        <div class="login-box" style="width: 580px;">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><b>CLP</b></a>
            </div>
            <div class="login-box-body">
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
