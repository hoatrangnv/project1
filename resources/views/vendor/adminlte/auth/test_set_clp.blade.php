@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
    <body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-box-body">
                <span>@include('flash::message')</span>
                <form action="{{ route('test.setCLP') }}" method="post">
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        @if ($errors->has('email'))
                            <span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="text" name="amount" class="form-control" placeholder="Amount of CLP">
                    </div>
                    @if (Config::get('app.enable_captcha'))
                    <div class="form-group">
                        {!! app('captcha')->display()!!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
						        {{ $errors->first('g-recaptcha-response') }}
					        </span>
                        @endif
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('adminlte::layouts.partials.scripts_auth')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    </body>

@endsection
