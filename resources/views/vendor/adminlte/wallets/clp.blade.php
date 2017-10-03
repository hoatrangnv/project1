<?php
use App\Http\Controllers\Wallet\Views\WalletViewController;
?>
@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::wallet.clp') }}
@endsection

@section('main-content')
    <style>
        #myTable tbody tr:hover {
            background-color: #f5f5f5 !important;
        }

        tr.selected {
            background-color: #5bc0de !important;
        }

        tr.checked {
            background-color: #d9edf7 !important;
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
    <?php  echo WalletViewController::viewAllWallet(); ?>
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
                                <th class="wallet-amount">{{ Auth()->user()->userCoin->clpCoinAmount }}  </th>
                                <th>
                                    <a href="#" class="btn bg-olive" data-toggle="modal"
                                       data-target="#sell">{{ trans('adminlte_lang::wallet.sell_clp') }}</a>
                                    <a href="#" class="btn bg-olive" data-toggle="modal"
                                       data-target="#buy-package">{{ trans("adminlte_lang::wallet.buy_package") }}</a>
                                    <a href="#" class="btn bg-olive" data-toggle="modal"
                                       data-target="#withdraw">{{ trans("adminlte_lang::wallet.withdraw") }}</a>
                                    <a href="#" class="btn bg-olive" data-toggle="modal"
                                       data-target="#deposit">{{ trans("adminlte_lang::wallet.deposit") }}</a>
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
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-2 no-padding">
                        {{ Form::select('wallet_type', array_merge(['0' => 'Choose a type'], $wallet_type), ($requestQuery && isset($requestQuery['type']) ? $requestQuery['type'] : 0), ['class' => 'form-control input-sm', 'id' => 'wallet_type']) }}
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
    <!--Sell CLP modal-->
    <div class="modal fade" id="sell" style="display: none;">
        {{ Form::open(array('url' => 'wallets/btctranfer')) }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ trans("adminlte_lang::wallet.sell_clp")}}</h4>
                </div>
                <div class="modal-body">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Sell CLP&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default maxsellclp" data-type="maxsellclp">{{ Auth()->user()->userCoin->clpCoinAmount }}</a></h4>
              </div>
              <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                {{ Form::number('clpAmount', '', array('class' => 'form-control input-sm switch-CLP-to-BTC-sellclp', 'step' => '0.0001','placeholder' => "CLP Amount")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                {{ Form::number('btcAmount', '', array('class' => 'form-control input-sm switch-BTC-to-CLP-sellclp', 'step' => '0.0001', 'placeholder' => "Min 0.0001")) }}
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
    <div class="modal fade" id="buy-package" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Investment Package</h4>
                </div>
                {{ Form::open(array('url' => 'packages/invest', 'id'=>'formPackage')) }}
                <div class="modal-body">
                    <div id="msg_package"></div>
                    <table class="table" id="myTable">
                        <thead>
                        <tr id="table_th">
                            <th>{{ trans('adminlte_lang::package.name') }}</th>
                            <th>{{ trans('adminlte_lang::package.price') }}</th>
                            <th>{{ trans('adminlte_lang::package.clp_coin') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($packages as $package)
                            <tr{{ Auth::user()->userData->packageId > 0 && $package->id == Auth::user()->userData->packageId ?  ' class=checked':'' }} data-id
                            ="{{ $package->pack_id }}">
                            <td>{{ $package->name }}</td>
                            <td>${{ number_format($package->price) }}</td>
                            <td>{{ number_format($package->price / Auth::user()->getCLPUSDRate(), 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a href="/term-condition.html" target="_blank">Term and condition</a>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="packageId" id="packageId"
                           value="{{ Auth::user()->userData->packageId }}">
                    <button class="btn btn-success btn-block"
                            id="btn_submit">{{ trans('adminlte_lang::wallet.buy_package') }}</button>
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--withdrawa modal-->
    {{ Form::open(array('url' => 'wallets/clpwithdraw'))}}
    <div class="modal fade" id="withdraw" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Withdraw</h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="input-group">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">WithRaw&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default withdrawclp" data-type="withdrawclp">{{ Auth()->user()->userCoin->clpCoinAmount }}</a></h4>
          </div>
          <div class="modal-body">
                <div class="box no-border">
                    <div class="box-body" style="padding-top:0;">
                        <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                {{ Form::number('withdrawAmount', '', array('class' => 'form-control input-sm', 'step' => '0.0001', 'placeholder' => "Min 0.0001")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                {{ Form::number('withdrawAmount', '', array('class' => 'form-control input-sm withdrawclpinput', 'step' => '0.0001', 'placeholder' => "Min 0.0001")) }}
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                {{ Form::text('walletAddress', '', array('class' => 'form-control input-sm', 'placeholder' => "Ethereum address E.g. 0xbHB5XMLmzFVj8ALj6mfBsbifRoD4miY36v")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {{ Form::number('withdrawOPT', '', array('class' => 'form-control input-sm', 'placeholder' => "2FA code E.g. 123456")) }}
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
                                    <h5 for="qrcode" style="font-weight: 600; color:#34495e">Your CLP Wallet
                                        address</h5>
                                    <h6 class="wallet-address"></h6>
                                    <h5 for="qrcode" style="font-weight: 600; color: #34495e; margin-bottom: 0px">CLP
                                        Wallet link</h5>
                                    <a class="link-blockchain" href="" target="_blank">etherscan</a>
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
    <!--Tranfer modal-->
    <div class="modal fade" id="tranfer" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ trans("adminlte_lang::wallet.transfer")}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-clp"></i></span>
                            {{ Form::number('clpAmount', '', array('class' => 'form-control input-sm', 'id' => 'clpAmount', 'step' => '0.0001', 'placeholder' => "Min 0.0001")) }}
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                            {{ Form::text('username', '', array('class' => 'form-control input-sm', 'id' => 'clpUsername', 'placeholder' => "Username")) }}
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            {{ Form::number('withdrawOPT', '', array('class' => 'form-control input-sm', 'id' => 'clpOTP', 'placeholder' => "2FA Code E.g. 123456")) }}
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{ Form::submit(trans('adminlte_lang::wallet.transfer'), array('class' => 'btn btn-primary', 'id' => 'clptranfer')) }}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        $(document).ready(function () {
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
        });
        $('#clptranfer').on('click', function () {
            var clpAmount = $('#clpAmount').val();
            var clpUsername = $('#clpUsername').val();
            var clpOTP = $('#clpOTP').val();
            if($.trim(clpAmount) == ''){
                $("#clpAmount").parents("div.form-group").addClass('has-error');
                $("#clpAmount").parents("div.form-group").find('.help-block').text('The Amount field is required');
            }else{
                $("#clpAmount").parents("div.form-group").removeClass('has-error');
                $("#clpAmount").parents("div.form-group").find('.help-block').text('');
            }
            if($.trim(clpUsername) == ''){
                $("#clpUsername").parents("div.form-group").addClass('has-error');
                $("#clpUsername").parents("div.form-group").find('.help-block').text('The Username field is required');
            }else{
                $("#clpUsername").parents("div.form-group").removeClass('has-error');
                $("#clpUsername").parents("div.form-group").find('.help-block').text('');
            }
            if($.trim(clpOTP) == ''){
                $("#clpOTP").parents("div.form-group").addClass('has-error');
                $("#clpOTP").parents("div.form-group").find('.help-block').text('The OTP field is required');
            }else{
                $("#clpOTP").parents("div.form-group").removeClass('has-error');
                $("#clpOTP").parents("div.form-group").find('.help-block').text('');
            }
            if($.trim(clpAmount) != '' && $.trim(clpUsername) != '' && $.trim(clpOTP) != ''){
                $.ajax({
                    url: "{{ url('wallets/clptranfer') }}",
                    data: {clpAmount: clpAmount, clpUsername: clpUsername, clpOTP: clpOTP}
                }).done(function (data) {
                    if (data.err) {
                        if(typeof data.msg !== undefined){
                            if(typeof data.msg.clpAmountErr !== undefined) {
                                $("#clpAmount").parents("div.form-group").addClass('has-error');
                                $("#clpAmount").parents("div.form-group").find('.help-block').text(data.msg.clpAmountErr);
                            }else {
                                $("#clpAmount").parents("div.form-group").removeClass('has-error');
                                $("#clpAmount").parents("div.form-group").find('.help-block').text('');
                            }
                            if(typeof data.msg.clpUsernameErr !== undefined) {
                                $("#clpUsername").parents("div.form-group").addClass('has-error');
                                $("#clpUsername").parents("div.form-group").find('.help-block').text(data.msg.clpUsernameErr);
                            }else if(typeof data.msg.user !== undefined) {
                                $("#clpUsername").parents("div.form-group").addClass('has-error');
                                $("#clpUsername").parents("div.form-group").find('.help-block').text(data.msg.clpUsernameErr);
                            }else {
                                $("#clpUsername").parents("div.form-group").removeClass('has-error');
                                $("#clpUsername").parents("div.form-group").find('.help-block').text('');
                            }
                            if(typeof data.msg.clpOTPErr !== undefined) {
                                $("#clpOTP").parents("div.form-group").addClass('has-error');
                                $("#clpOTP").parents("div.form-group").find('.help-block').text(data.msg.clpOTPErr);
                            }else {
                                $("#clpOTP").parents("div.form-group").removeClass('has-error');
                                $("#clpOTP").parents("div.form-group").find('.help-block').text('');
                            }
                        }
                    } else {
                        location.href = '{{ url()->current() }}';
                    }
                });
            }
        });
        });
        var packageId = {{ Auth::user()->userData->packageId }};
        var packageIdPick = packageId;
        $(document).ready(function () {
            $('#myTable tbody').on('click', 'tr', function () {
                var _packageId = parseInt($(this).data('id'));
                if (_packageId > 0) {
                    if (_packageId < packageId) {
                        $('#msg_package').html("<div class='alert alert-danger'>You cant not downgrate package.</div>");
                    } else if (_packageId == packageId) {
                        $('#msg_package').html("<div class='alert alert-danger'>You purchased this package.</div>");
                    } else {
                        $('#msg_package').html("");
                        $('#myTable tbody tr').removeClass('selected');
                        $('#table_th').removeClass('selected');
                        $(this).addClass('selected');
                        $("#packageId").val(_packageId);
                        packageIdPick = _packageId;
                    }
                }
            });
            $('#btn_submit').on('click', function () {
                if (packageIdPick > packageId) {
                    $('#formPackage').submit();
                } else {
                    alert('You cant not this package');
                }
            });
        });

        $.ajax({
            url: "{{ url('wallets/deposit') }}?action=clp",
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
                    }
                    // ......
                });
            }


            $(".switch-BTC-to-CLP-sellclp").on('keyup change mousewheel', function (){
                var value = $(this).val();
                var type = "BtcToClp";
                //send
                var result = switchChange(value,type);
            });

            $( ".switch-CLP-to-BTC-sellclp" ).on('keyup change mousewheel', function() {
                var value = $(this).val();
                var type = "ClpToBtc";
                //send
                var result = switchChange(value,type);
            });

            function switchChangeSellClp(value,type){
                $.ajax({
                    beforeSend: function(){
                      // Handle the beforeSend event
                    },
                    url:"switchbtcclp",
                    type:"get",
                    data : {
                        type: type,
                        value: value
                    },
                    success : function(result){
                        if( type == "BtcToClp" ){
                            if(result.success) {
                                $(".switch-CLP-to-BTC-sellclp").val(result.result);
                            }
                        } else {
                            if(result.success) {
                                $(".switch-BTC-to-CLP-sellclp").val(result.result);
                            }
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("some error");
                    },
                    complete: function(){

                    }
                    // ......
                });
            }

             //get total value;
            var data = {{ Auth()->user()->userCoin->clpCoinAmount }};

            $( ".maxsellclp" ).click(function() {
                $(".switch-CLP-to-BTC-sellclp").val(data)
                var type = "UsdToClp";
                var result = switchChangeSellClp(data,type);
            });

            $( ".withdrawclp" ).click(function() {
                $(".withdrawclpinput").val(data)
            });




    </script>
@endsection