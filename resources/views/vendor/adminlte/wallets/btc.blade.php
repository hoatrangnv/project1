<?php

use App\Http\Controllers\Wallet\Views\WalletViewController;
?>
@extends('adminlte::layouts.member')

@section('contentheader_title')
{{ trans('adminlte_lang::wallet.btc') }}
@endsection

@section('main-content')
<style>
    a {
        color: inherit;
        text-decoration: none;
        cursor: pointer;
        outline: 0;
    }
</style>
@if ( session()->has("errorMessage") )
<div class="callout callout-danger">
    <h4>Warning!</h4>
    <p>{!! session("errorMessage") !!}</p>
</div>
{{ session()->forget('errorMessage') }}
@elseif ( session()->has("successMessage") )
<div class="callout callout-success">
    <h4>Success</h4>
    <p>{!! session("successMessage") !!}</p>
</div>
{{ session()->forget('successMessage') }}
@else
<div></div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<?php echo WalletViewController::viewAllWallet(); ?>
<div class="row">
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="box">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped wallet-table">
                        <tbody>
                            <tr>
                                <th class="icon-wallet">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path>
                                    </svg>
                                </th>
                                <th class="wallet-amount">
                                    <i class="fa fa-btc"></i><span class="btc-amount">{{ Auth()->user()->userCoin->btcCoinAmount }}</span>
                                </th>
                                <th>
                                    <button class="btn bg-olive" data-toggle="modal"
                                            data-target="#deposit">{{trans("adminlte_lang::wallet.deposit")}}</button>
                                    <button class="btn bg-olive" data-toggle="modal"
                                            data-target="#withdraw">{{trans("adminlte_lang::wallet.withdraw")}}</button>
                                    <button class="btn bg-olive" data-toggle="modal"
                                            data-target="#buy">{{trans("adminlte_lang::wallet.tranfer_to_clp")}}</button>
                                    <button class="btn bg-olive" data-toggle="modal"
                                            data-target="#tranfer">{{trans("adminlte_lang::wallet.transfer")}}</button>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <!-- /.col -->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-2 no-padding">
                    {{ Form::select('wallet_type', $wallet_type, ($requestQuery && isset($requestQuery['type']) ? $requestQuery['type'] : 0), ['class' => 'form-control input-sm', 'id' => 'wallet_type']) }}
                </div>
                <div class="col-xs-2">
                    {!! Form::button('Filter', ['class' => 'btn btn-sm btn-primary', 'id' => 'btn_filter']) !!}
                    {!! Form::button('Clear', ['class' => 'btn btn-sm bg-olive', 'id' => 'btn_filter_clear']) !!}
                </div>
            </div>
            <div class="box-body" style="padding-top:0;">
                <table class="table table-bordered table-hover table-striped dataTable">
                    <tr>
                        <th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
                        <th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
                        <th>{{ trans('adminlte_lang::wallet.wallet_type') }}</th>
                        <th>{{ trans('adminlte_lang::wallet.wallet_in') }}</th>
                        <th>{{ trans('adminlte_lang::wallet.wallet_out') }}</th>
                        <th>{{ trans('adminlte_lang::wallet.wallet_info') }}</th>
                    </tr>
                    <tbody>
                        @foreach ($wallets as $key => $wallet)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $wallet->created_at }}</td>
                            <td>{{ $wallet_type && isset($wallet_type[$wallet->type]) ? $wallet_type[$wallet->type] : '' }}</td>
                            <td>
                                @if($wallet->inOut=='in')
                                +{{ $wallet->amount }}
                                @endif
                            </td>
                            <td>
                                @if($wallet->inOut=='out')
                                -{{ $wallet->amount }}
                                @endif
                            </td>
                            <td>{{ $wallet->note }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $wallets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--Deposit modal-->
<div class="modal fade" id="deposit" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Deposit to your wallet</h4>
            </div>
            <div class="modal-body">
                <!-- <div class="col-lg-12"> -->
                <div class="box no-border" style="border-top:none;">
                    <div class="box-body">
                        <div class="form-group" style="text-align: center">
                            <h5 for="qrcode" style="font-weight: 600; color:#34495e">Your BTC Wallet
                                address</h5>
                            <div class="form-group">
                                <input type="text" value="{{ $walletAddress }}" class="wallet-address fwbBcc" id="wallet-address" readonly="true">
                                    <button class="btnwallet-address cp-btc" data-clipboard-target="#wallet-address" title="copy">
                                        <i class="fa fa-clone"></i>
                                    </button>
                            </div>

                            <!-- Trigger -->

                            <h5 for="qrcode" style="font-weight: 600; color: #34495e; margin-bottom: 0px">BTC
                                Wallet link</h5>
                            <a class="link-blockchain" href="https://blockchain.info/address/{{ $walletAddress }}" target="_blank">blockchain</a>, <a
                                class="link-blockexplorer" href="https://blockexplorer.com/address/{{ $walletAddress }}" target="_blank">blockexplorer</a>
                            <center>
                                <div id="qrcode" style="padding-bottom: 10px;"></div>
                            </center>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Withdraw modal-->
{{ Form::open(array('url' => 'wallets/btcwithdraw'))}}
<div class="modal fade" id="withdraw" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Withdraw&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btc-amount maxbtcwithdraw" data-type="btcwithdraw">{{ Auth()->user()->userCoin->btcCoinAmount }}</a></h4>
            </div>
            <div class="modal-body">
                <div class="box no-border">
                    <div class="box-body" style="padding-top:0;">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                            {{ Form::number('withdrawAmount', '', array('class' => 'form-control input-sm btcwithdraw ', 'step' => '0.0001', 'placeholder' => "Min 0.0001", )) }}
                        </div>
                        <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                {{ Form::text('walletAddress', '', array('class' => 'form-control input-sm', 'placeholder' => "Bitcoin address E.g. 1HB5XMLmzFVj8ALj6mfBsbifRoD4miY36v")) }}
                            </div>
                            <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    {{ Form::number('withdrawOPT', '', array('class' => 'form-control input-sm', 'placeholder' => "2FA Code E.g. 123456")) }}
                                </div>
                                </div>
                                </div>
                                <div class="pull-right">
                                    <span><i>{{ trans("adminlte_lang::wallet.fee") }}:{{ config("app.fee_withRaw_BTC")}}</i></span>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    {{ Form::submit(trans('adminlte_lang::default.submit'), array('class' => 'btn btn-primary')) }}
                                </div>
                                </div>
                                <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                                </div>
                                {{ Form::close() }}

                                <!--Buy CLP modal-->
                                <div class="modal fade" id="buy" style="display: none;">
                                    {{ Form::open(array('url' => 'wallets/btcbuyclp')) }}
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">{{ trans("adminlte_lang::wallet.tranfer_to_clp")}}&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btc-amount maxbuyclp" data-type="btctranfer">{{ Auth()->user()->userCoin->btcCoinAmount }}</a></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="box no-border">
                                                    <div class="box-body" style="padding-top:0;">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                                            {{ Form::number('btcAmount', '', array('class' => 'form-control input-sm switch-BTC-to-CLP', 'step' => '0.00001', 'placeholder' => "Min 0.0001")) }}
                                                        </div>
                                                        <br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><span class="icon-clp-icon"></span></span>
                                                                {{ Form::number('clpAmount', '', array('class' => 'form-control input-sm switch-CLP-to-BTC', 'step' => '0.00001','placeholder' => "CLP Amount")) }}
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                {{ Form::submit(trans('adminlte_lang::default.submit'), array('class' => 'btn btn-primary')) }}
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                    {{ Form::close() }}
                                </div>

                                <!--Tranfer modal-->
                                <div class="modal fade" id="tranfer" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">{{ trans("adminlte_lang::wallet.transfer")}}&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btc-amount maxbtctranfer" data-type="btctranfer">{{ Auth()->user()->userCoin->btcCoinAmount }}</a></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="box no-border">
                                                    <div class="box-body" style="padding-top:0;">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                                                {{ Form::number('btcAmount', '', array('class' => 'form-control input-sm switch-BTC-to-CLP-tranfer', 'step' => '0.00001', 'placeholder' => "Min 0.0001", 'id' => 'btcAmount' )) }}
                                                            </div>
                                                            <span class="help-block"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                                {{ Form::text('btcUsername', '', array('class' => 'form-control input-sm', 'id' => 'btcUsername','placeholder' => "Username")) }}
                                                            </div>
                                                            <span class="help-block"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                                                {{ Form::number('btcUid', '', array('class' => 'form-control input-sm', 'id' => 'btcUid', 'placeholder' => "Id")) }}
                                                            </div>
                                                            <span class="help-block"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                                {{ Form::number('btcOTP', '', array('class' => 'form-control input-sm', 'id' => 'btcOTP' ,'placeholder' => "2FA Code E.g. 123456")) }}
                                                            </div>
                                                            <span class="help-block"></span>
                                                        </div>
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                {{ Form::submit(trans('adminlte_lang::default.submit'), array('class' => 'btn btn-primary', 'id' => 'btctranfer')) }}
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <script src="{{ URL::to("js/qrcode.min.js") }}"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
                                <script>
$(document).ready(function () {
    $('.btnwallet-address').tooltip({
        trigger: 'click',
        placement: 'bottom'
    });

    function setTooltip(message) {
        $('.btnwallet-address')
                .attr('data-original-title', message)
                .tooltip('show');
    }

    function hideTooltip() {
        setTimeout(function () {
            $('button').tooltip('hide');
        }, 1000);
    }

    var clipboard = new Clipboard('.btnwallet-address');
    clipboard.on('success', function (e) {
        e.clearSelection();
        setTooltip('Copied!');
        hideTooltip();
    });

    $('#btn_filter').on('click', function () {
        var wallet_type = parseInt($('#wallet_type option:selected').val());
        if (wallet_type > 0) {
            location.href = '{{ url()->current() }}?type=' + wallet_type;
        } else {
            alert('Please choose a type!');
            return false;
        }
    });
    $('#btn_filter_clear').on('click', function () {
        location.href = '{{ url()->current() }}';
    });
    var mytimer;
    $('#btcUid').on('blur onmouseout keyup', function () {
        clearTimeout(mytimer);
        var search = $(this).val();
        if (search.length >= 1) {
            mytimer = setTimeout(function () {
                $.ajax({
                    type: "GET",
                    url: "/users/search",
                    data: {id: search}
                }).done(function (data) {
                    if (data.err) {
                        $("#btcUid").parents("div.form-group").addClass('has-error');
                        $("#btcUid").parents("div.form-group").find('.help-block').text('The Uid field is required');
                        $('#btcUsername').val('');
                    } else {
                        $('#btcUid').parent().removeClass('has-error');
                        $("#btcUid").parents("div.form-group").find('.help-block').text('');
                        $('#btcUsername').parent().removeClass('has-error');
                        $('#btcUsername').parent().find('.help-block').text('');
                        $('#btcUsername').val(data.username);
                    }
                });
            }, 1000);
        }
    });
    $('#btcUsername').on('blur onmouseout keyup', function () {
        clearTimeout(mytimer);
        var search = $(this).val();
        if (search.length >= 3) {
            mytimer = setTimeout(function () {
                $.ajax({
                    type: "GET",
                    url: "/users/search",
                    data: {username: search}
                }).done(function (data) {
                    if (data.err) {
                        $("#btcUsername").parents("div.form-group").addClass('has-error');
                        $("#btcUsername").parents("div.form-group").find('.help-block').text(data.err);
                        $('#btcUid').val('');
                    } else {
                        $('#btcUsername').parent().removeClass('has-error');
                        $("#btcUsername").parents("div.form-group").find('.help-block').text('');
                        $('#btcUid').parent().removeClass('has-error');
                        $('#btcUid').parent().find('.help-block').text('');
                        $('#btcUid').val(data.id);
                    }
                });
            }, 1000);
        }
    });
    $('#btctranfer').on('click', function () {
        var btcAmount = $('#btcAmount').val();
        var btcUsername = $('#btcUsername').val();
        var btcOTP = $('#btcOTP').val();
        var btcUid = $('#btcUid').val();
        if ($.trim(btcAmount) == '') {
            $("#btcAmount").parents("div.form-group").addClass('has-error');
            $("#btcAmount").parents("div.form-group").find('.help-block').text('The Amount field is required');
        } else {
            $("#btcAmount").parents("div.form-group").removeClass('has-error');
            $("#btcAmount").parents("div.form-group").find('.help-block').text('');
        }
        if ($.trim(btcUsername) == '') {
            $("#btcUsername").parents("div.form-group").addClass('has-error');
            $("#btcUsername").parents("div.form-group").find('.help-block').text('The Username field is required');
        } else {
            $("#btcUsername").parents("div.form-group").removeClass('has-error');
            $("#btcUsername").parents("div.form-group").find('.help-block').text('');
        }
        if ($.trim(btcUid) == '') {
            $("#btcUid").parents("div.form-group").addClass('has-error');
            $("#btcUid").parents("div.form-group").find('.help-block').text('The Uid field is required');
        } else {
            $("#btcUid").parents("div.form-group").removeClass('has-error');
            $("#btcUid").parents("div.form-group").find('.help-block').text('');
        }
        if ($.trim(btcOTP) == '') {
            $("#btcOTP").parents("div.form-group").addClass('has-error');
            $("#btcOTP").parents("div.form-group").find('.help-block').text('The OTP field is required');
        } else {
            $("#btcOTP").parents("div.form-group").removeClass('has-error');
            $("#btcOTP").parents("div.form-group").find('.help-block').text('');
        }
        if ($.trim(btcAmount) != '' && $.trim(btcUsername) != '' && $.trim(btcOTP) != '') {
            $.ajax({
                url: "{{ url('wallets/btctranfer') }}",
                data: {btcAmount: btcAmount, btcUsername: btcUsername, btcOTP: btcOTP, btcUid: btcUid}
            }).done(function (data) {
                if (data.err) {
                    if (typeof data.msg !== undefined) {
                        if (data.msg.btcAmountErr !== '') {
                            $("#btcAmount").parents("div.form-group").addClass('has-error');
                            $("#btcAmount").parents("div.form-group").find('.help-block').text(data.msg.btcAmountErr);
                        } else {
                            $("#btcAmount").parents("div.form-group").removeClass('has-error');
                            $("#btcAmount").parents("div.form-group").find('.help-block').text('');
                        }

                        if (data.msg.btcUsernameErr !== '') {
                            $("#btcUsername").parents("div.form-group").addClass('has-error');
                            $("#btcUsername").parents("div.form-group").find('.help-block').text(data.msg.btcUsernameErr);
                        } else {
                            $("#btcUsername").parents("div.form-group").removeClass('has-error');
                            $("#btcUsername").parents("div.form-group").find('.help-block').text('');
                        }

                        if (data.msg.btcUidErr !== '') {
                            $("#btcUid").parents("div.form-group").addClass('has-error');
                            $("#btcUid").parents("div.form-group").find('.help-block').text(data.msg.btcUidErr);
                        } else {
                            $("#btcUid").parents("div.form-group").removeClass('has-error');
                            $("#btcUid").parents("div.form-group").find('.help-block').text('');
                        }

                        if (data.msg.btcOTPErr !== '') {
                            $("#btcOTP").parents("div.form-group").addClass('has-error');
                            $("#btcOTP").parents("div.form-group").find('.help-block').text(data.msg.btcOTPErr);
                        } else {
                            $("#btcOTP").parents("div.form-group").removeClass('has-error');
                            $("#btcOTP").parents("div.form-group").find('.help-block').text('');
                        }
                    }
                } else {
                    $('#tranfer').modal('hide');
                    swal("Transfer successfully!");
                    location.href = '{{ url()->current() }}';
                }
            });
        }
    });
});

var getBtcCoin = setInterval(function () {
    $.get("getbtccoin", function (data) {
        $(".btc-amount").html(data);
    });
    }
    , {{ config("app.time_interval")}
});

var qrcode = new QRCode(document.getElementById("qrcode"), {
    width: 180,
    height: 180,
    text: '{{ $walletAddress }}',
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});

$(".switch-BTC-to-CLP").on('keyup change mousewheel', function () {
    var value = $(this).val();
    var result = value / globalCLPBTC;
    $(".switch-CLP-to-BTC").val(result.toFixed(5));
});

$(".switch-CLP-to-BTC").on('keyup change mousewheel', function () {
    var value = $(this).val();
    var result = value * globalCLPBTC;
    $(".switch-BTC-to-CLP").val(result.toFixed(5));
});


$(".maxbtcwithdraw").click(function () {
    $(".btcwithdraw").val($(".btc-amount").html())
});

$(".maxbuyclp").click(function () {
    $(".switch-BTC-to-CLP").val($(".btc-amount").html());
    var amountCLP = $(".btc-amount").html() / globalCLPBTC;
    $(".switch-CLP-to-BTC").val(amountCLP.toFixed(5));
});

$(".maxbtctranfer").click(function () {
    $(".switch-BTC-to-CLP-tranfer").val($(".btc-amount").html());
});

</script>
@endsection