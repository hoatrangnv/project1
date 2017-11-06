@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Withdrawal Confirmation
@endsection

@section('content')

    <body class="login-page">

    <div id="app">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><img src="{{ url('/') }}/img/logo_gold.png"/><b style="margin-left: 5px; vertical-align: middle;">CLP</b></a>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                {{ session()->forget('error') }}
            @endif
            @if (session('successMessage'))
                <div class="alert alert-success">
                    {{ session('successMessage') }}
                </div>
                {{ session()->forget('successMessage') }}
            @endif
            <div class="login-box-body">
                <p class="login-box-msg">Withdrawal {{ ($withdrawConfirm->type == 'btc' ? 'BTC' : 'CLP') }} Confirmation</p>
                @if(!$isConfirm)
                    <form class="form-horizontal" role="form" method="POST" id="withdraw_confirm">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                            {{ Form::number('withdrawAmount', $withdrawConfirm->withdrawAmount, array('class' => 'form-control input-sm', 'disabled' => "disabled")) }}
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            {{ Form::text('walletAddress', $withdrawConfirm->walletAddress, array('class' => 'form-control input-sm', 'disabled' => "disabled")) }}
                        </div>

                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary" id="confirm_submit">
                                        Confirm
                                    </button>
                                    <input type="hidden" value="0" name="status" id="withdraw_status">
                                    <button type="button" class="btn btn-danger" id="withdraw_cancel">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                            {{ Form::number('withdrawAmount', $withdrawConfirm->withdrawAmount, array('class' => 'form-control input-sm', 'disabled' => "disabled")) }}
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            {{ Form::text('walletAddress', $withdrawConfirm->walletAddress, array('class' => 'form-control input-sm', 'disabled' => "disabled")) }}
                        </div>
                        
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('adminlte::layouts.partials.scripts_auth')
    <script>
        $(document).ready(function(){
            $('#withdraw_cancel').on('click', function () {
                if (confirm("Are you sure?")) {
                    $('#withdraw_status').val("1");
                    $('#withdraw_confirm').submit();
                    return true;
                }
                return false;
            });

            $('#confirm_submit').on('click', function(){
                if (confirm("Are you sure?")) {
                    $('#confirm_submit').attr('disabled', true);
                    $('#withdraw_confirm').submit();
                    return true;
                }
                return false;
            });
        });
    </script>
    </body>

@endsection
