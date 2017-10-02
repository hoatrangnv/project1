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
                                <th class="wallet-amount"><i class="fa fa-btc"
                                                             aria-hidden="true"></i>{{ Auth()->user()->userCoin->btcCoinAmount }}
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
                        {{ Form::select('wallet_type', array_merge(['0' => 'Choose a type'], $wallet_type), ($requestQuery && isset($requestQuery['type']) ? $requestQuery['type'] : 0), ['class' => 'form-control input-sm', 'id' => 'wallet_type']) }}
                    </div>
                    <div class="col-xs-1">
                        {!! Form::button('Filter', ['class' => 'btn btn-sm btn-primary', 'id' => 'btn_filter']) !!}
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
                    <h4 class="modal-title">Deposit</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card box">
                            <div class="card-heading  b-b b-light" style="text-align: center">
                                <h2>Deposit to your wallet</h2>
                            </div>
                            <div class="card-body">
                                <div class="form-group" style="text-align: center">
                                    <h5 for="qrcode" style="font-weight: 600; color:#34495e">Your BTC Wallet
                                        address</h5>
                                    <h6 class="wallet-address"></h6>
                                    <h5 for="qrcode" style="font-weight: 600; color: #34495e; margin-bottom: 0px">BTC
                                        Wallet link</h5>
                                    <a class="link-blockchain" href="" target="_blank">blockchain</a>, <a
                                            class="link-blockexplorer" href="" target="_blank">blockexplorer</a>
                                    <center>
                                        <div id="qrcode" style="padding-bottom: 10px;"></div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <h4 class="modal-title">WithRaw&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default maxbtcwithdraw" data-type="btcwithdraw">{{ Auth()->user()->userCoin->btcCoinAmount }}</a></h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                {{ Form::number('withdrawAmount', '', array('class' => 'form-control input-sm btcwithdraw', 'step' => '0.0001', 'placeholder' => "Min 0.0001")) }}
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{ Form::submit(trans('adminlte_lang::wallet.btn_withdraw'), array('class' => 'btn btn-primary')) }}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{ Form::close() }}

    <!--Buy CLP modal-->
    <div class="modal fade" id="buy" style="display: none;">
        {{ Form::open(array('url' => 'wallets/btctranfer')) }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ trans("adminlte_lang::wallet.tranfer_to_clp")}}&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default maxbuyclp" data-type="btctranfer">{{ Auth()->user()->userCoin->btcCoinAmount }}</a></h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                {{ Form::number('btcAmount', '', array('class' => 'form-control input-sm switch-BTC-to-CLP', 'step' => '0.0001', 'placeholder' => "Min 0.0001")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                {{ Form::number('clpAmount', '', array('class' => 'form-control input-sm switch-CLP-to-BTC', 'step' => '0.0001','placeholder' => "CLP Amount")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {{ Form::number('withdrawOPT', '', array('class' => 'form-control input-sm', 'placeholder' => "2FA Code E.g. 123456")) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{ Form::submit(trans('adminlte_lang::wallet.transfer'), array('class' => 'btn btn-primary')) }}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        {{ Form::close() }}
    </div>

    <!--Tranfer modal-->
    <div class="modal fade" id="tranfer" style="display: none;">
        {{ Form::open(array('url' => 'wallets/btctranfer')) }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ trans("adminlte_lang::wallet.transfer")}}&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default maxbtctranfer" data-type="btctranfer">{{ Auth()->user()->userCoin->btcCoinAmount }}</a></h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                {{ Form::number('btcAmount', '', array('class' => 'form-control input-sm switch-BTC-to-CLP-tranfer', 'step' => '0.0001', 'placeholder' => "Min 0.0001")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                {{ Form::number('username', '', array('class' => 'form-control input-sm switch-CLP-to-BTC-tranfer', 'step' => '0.0001','placeholder' => "Username")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {{ Form::number('withdrawOPT', '', array('class' => 'form-control input-sm', 'placeholder' => "2FA Code E.g. 123456")) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{ Form::submit(trans('adminlte_lang::wallet.transfer'), array('class' => 'btn btn-primary')) }}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        {{ Form::close() }}
    </div>

    <script src="{{ URL::to("js/qrcode.min.js") }}"></script>

    <script>
        $(document).ready(function(){
            $('#btn_filter').on('click', function () {
                var wallet_type = parseInt($('#wallet_type option:selected').val());
                if(wallet_type > 0){
                    location.href = '{{ url()->current() }}?type='+wallet_type;
                }else{
                    alert('Please choose a type!');
                    return false;
                }
            })
        });
        var getBtcCoin = setInterval(function () {
            getBtccoin();
        },{{ config("app.time_interval")}});
        //get wallet code and render code to qrcode
        $.ajax({
            url: "{{ url('wallets/deposit') }}?action=btc",
        }).done(function (data) {
            if (!data.err) {
                $(".wallet-address").html(data.walletAddress);
                $(".link-blockchain").attr("href", "https://blockchain.info/address/" + data.walletAddress);
                $(".link-blockexplorer").attr("href", "https://blockexplorer.com/address/" + data.walletAddress);
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    text: data.walletAddress,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            } else {
                $(".wallet-address").html(data.err);
            }
        });

        function getBtccoin() {
            $.get("getbtccoin", function (data) {
                $(".btcCoin").html(data);
            });
        };

        //Switch Btc and Clp

        $(".switch-BTC-to-CLP").on('keyup change mousewheel', function () {
            var value = $(this).val();
            var type = "BtcToClp";
            //send
            var result = switchChange(value, type);
        });

        $(".switch-CLP-to-BTC").on('keyup change mousewheel', function () {
            var value = $(this).val();
            var type = "ClpToBtc";
            //send
            var result = switchChange(value, type);
        });


        function switchChange(value, type) {
            $.ajax({
                beforeSend: function () {
                    // Handle the beforeSend event
                },
                url: "switchbtcclp",
                type: "get",
                data: {
                    type: type,
                    value: value
                },
                success: function (result) {
                    if (type == "BtcToClp") {
                        if (result.success) {
                            $(".switch-CLP-to-BTC").val(result.result);
                        }
                    } else {
                        if (result.success) {
                            $(".switch-BTC-to-CLP").val(result.result);
                        }
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("some error");
                },
                complete: function () {

                }
                // ......
            });
        }
        //Switch Btc and Clp tranfer

        $(".switch-BTC-to-CLP-tranfer").on('keyup change mousewheel', function () {
            var value = $(this).val();
            var type = "BtcToClp";
            //send
            var result = switchChange(value, type);
        });

        $(".switch-CLP-to-BTC-tranfer").on('keyup change mousewheel', function () {
            var value = $(this).val();
            var type = "ClpToBtc";
            //send
            var result = switchChange(value, type);
        });


        function switchChangeTranfer(value, type) {
            $.ajax({
                beforeSend: function () {
                    // Handle the beforeSend event
                },
                url: "switchbtcclp",
                type: "get",
                data: {
                    type: type,
                    value: value
                },
                success: function (result) {
                    if (type == "BtcToClp") {
                        if (result.success) {
                            $(".switch-CLP-to-BTC-tranfer").val(result.result);
                        }
                    } else {
                        if (result.success) {
                            $(".switch-BTC-to-CLP-tranfer").val(result.result);
                        }
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("some error");
                },
                complete: function () {

                }
                // ......
            });
        }
        var data = {{ Auth()->user()->userCoin->btcCoinAmount }};
         //get total value;
        $( ".maxbtcwithdraw" ).click(function() {
            $(".btcwithdraw").val(data)
        });
        
         //get total value;
        $( ".maxbuyclp" ).click(function() {
            $(".switch-BTC-to-CLP").val(data);
            switchChange(data,"BtcToClp");
        });
        
         //get total value;
        $( ".maxbtctranfer" ).click(function() {
            $(".switch-BTC-to-CLP-tranfer").val(data);
            switchChangeTranfer(data,"BtcToClp");
        });
        
    </script>
@endsection