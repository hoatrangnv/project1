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

                <form role="form" method="POST">
                    {!! csrf_field() !!}
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
                    <div class="form-group input-group-sm has-feedback{{ $errors->has('country') ? ' has-error' : '' }}">
                        {{ Form::select('country', $lstCountry, null, ['class' => 'form-control input-sm'], ['placeholder' => 'Choose a country']) }}
                        @if ($errors->has('country'))
                            <span class="help-block">
									{{ $errors->first('country') }}
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
                    <div class="form-group input-group-sm has-feedback{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" placeholder="{{ trans('adminlte_lang::user.phone') }}" name="phone" value="{{ old('phone') }}" class="form-control">
                        <span class="fa fa-phone form-control-feedback"></span>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                {{ $errors->first('phone') }}
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
                        <input type="password" placeholder="Retype password" name="password_confirmation" class="form-control">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group input-group-sm">
                        <input type="text" value="{{ $referrerId }}" name="refererId" class="form-control" disabled placeholder="Id Sponsor">
                    </div>
                    <div class="form-group input-group-sm">
                        <input type="text" value="{{ $referrerName }}" name="referrerName" class="form-control" disabled placeholder="Username Sponsor">
                    </div>
                    <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                        {!! app('captcha')->display()!!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
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
    <script>
        $(document).ready(function(){
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
    </body>

@endsection