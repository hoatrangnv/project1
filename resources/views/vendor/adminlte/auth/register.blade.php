@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.register') }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ URL::to('css/intlTelInput.css')}}">
    <style>
        .iti-flag {background-image: url("{{ URL::to('img/flags.png')}}");}

        @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
          .iti-flag {background-image: url("{{ URL::to('img/flags@2x.png')}}");}
        }
    </style>
    <body class="hold-transition register-page">
    <div id="app" v-cloak>
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ url('/home') }}"><img src="{{ url('/') }}/img/logo_gold.png"/><b style="margin-left: 5px; vertical-align: middle;">CLP</b></a>
            </div>
            <div class="signupSteps">
                <h2>
                    <span class="fa-stack fa-lg"><i class="fa fa-circle step"></i></span>Register 
                    <i class="fa fa-long-arrow-right"></i> 
                    <span class="fa-stack fa-lg"><i class="fa fa-circle-thin step"></i></span>Activate
                    <i class="fa fa-long-arrow-right"></i>
                    <span class="fa-stack fa-lg"><i class="fa fa-circle-thin step"></i></span>Complete
                </h2>
            </div>
            <div class="register-box-body">
                <p class="login-box-msg">{{ trans('adminlte_lang::message.registermember') }}</p>

                <form role="form" method="POST" action="{{ URL::to("/register") }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="refererId" value="{{$refererId}}" />
                    <input type="hidden" name="referrerName" value="{{$referrerName}}" />
                    <div class="form-group input-group-sm has-feedback{{ $errors->has('firstname') ? ' has-error' : '' }}">
                        <input type="text" placeholder="{{ trans('adminlte_lang::user.firstname') }}" name="firstname" value="{{ old('firstname') }}" autofocus="autofocus" class="form-control">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('firstname'))
                            <span class="help-block">
                                    {{ $errors->first('firstname') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group input-group-sm has-feedback{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <input type="text" placeholder="{{ trans('adminlte_lang::user.lastname') }}" name="lastname" value="{{ old('lastname') }}" autofocus="autofocus" class="form-control">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('lastname'))
                            <span class="help-block">
                                    {{ $errors->first('lastname') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group input-group-sm has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" placeholder="{{ trans('adminlte_lang::user.username') }}" name="name" value="{{ old('name') }}" autofocus="autofocus" class="form-control">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                    {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group input-group-sm has-feedback{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" id="phone" name="phone" class="form-control" hidden="">
                        <input type="text" id="country" name="country" class="form-control" style="display: none">
                        <input type="text" id="name_country" name="name_country" class="form-control" style="display: none">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                {{ $errors->first('phone') }}
                            </span>
                        @endif
                    </div>
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
                        <input type="password" placeholder="Retype Password" name="password_confirmation" class="form-control">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                        @endif
                    </div>
                    @if (Config::get('app.enable_captcha'))
                    <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                        {!! app('captcha')->display()!!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-7 form-group has-feedback{{ $errors->has('terms') ? ' has-error' : '' }}">
                            <label>
                                <div class="checkbox_register icheck">
                                    <label data-toggle="modal" data-target="#termsModal" class="" style="position: relative;">
                                        <input type="checkbox" name="terms">
                                        <a href="#" class="text-danger">{{ trans('adminlte_lang::user.terms_text') }}</a>
                                    </label>
                                </div>
                            </label>
                            @if ($errors->has('terms'))
                                <span class="help-block">
                                    {{ $errors->first('terms') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xs-4 col-xs-push-1">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::user.btn_register') }}</button>
                        </div>
                    </div>
                    
                    
                </form>


                <a href="{{ url('/login') }}" class="text-center">{{ trans('adminlte_lang::user.membreship') }}</a>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
    </div>
    @include('adminlte::layouts.partials.scripts_auth')
    @include('adminlte::auth.terms')
    <script src="{{ URL::to('js/intlTelInput.js')}}"></script>
    <script src="{{ URL::to('js/utils.js')}}"></script>
    <script>
        function changeUrl(){
            var URL = window.location.href;
            if (URL.split('/')[3] == 'ref') {
                window.history.pushState("object or string", "Title", "/register");
            }
        }
        $(document).ready(function(){
            var changurl = changeUrl();
            $("#phone").intlTelInput({
            });
            
            $('form').submit(function(){
                $("#phone").val($("#phone").intlTelInput("getNumber"));
                $("#country").val($("#phone").intlTelInput("getSelectedCountryData").dialCode);
                $("#name_country").val($("#phone").intlTelInput("getSelectedCountryData").name);
            });
            
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
            var mytimer;
            $('#refererId').on('blur onmouseout', function () {
                clearTimeout(mytimer);
                var search = $(this).val();
                if(search.length >= 1){
                    mytimer = setTimeout(function(){
                        $.ajax({
                            type: "GET",
                            url: "/users/search",
                            data: {id : search}
                        }).done(function(data){
                            if(data.err) {
                                $('#refererId').parent().addClass('has-error');
                                $('#refererIdError').text(data.err);
                                $('#referrerName').val('');
                            }else{
                                $('#referrerName').parent().removeClass('has-error');
                                $('#refererNameError').text('');
                                $('#refererId').parent().removeClass('has-error');
                                $('#refererIdError').text('');
                                $('#referrerName').val(data.username);
                            }
                        });
                    }, 1000);
                }
            });
            $('#referrerName').on('blur onmouseout', function () {
                clearTimeout(mytimer);
                var search = $(this).val();
                if(search.length >= 3){
                    mytimer = setTimeout(function(){
                        $.ajax({
                            type: "GET",
                            url: "/users/search",
                            data: {username : search}
                        }).done(function(data){
                            if(data.err) {
                                $('#referrerName').parent().addClass('has-error');
                                $('#refererNameError').text(data.err);
                                $('#refererId').val('');
                            }else{
                                $('#refererId').parent().removeClass('has-error');
                                $('#refererIdError').text('');
                                $('#referrerName').parent().removeClass('has-error');
                                $('#refererNameError').text('');
                                $('#refererId').val(data.id);
                            }
                        });
                    }, 1000);
                }
            });
        });
    </script>
    </body>

@endsection
