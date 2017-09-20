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
        @elseif ( session()->has("successMessage") )
            <div class="callout callout-success">
                <h4>Success!</h4>
                <p>{!! session("successMessage") !!}</p>
            </div>
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
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card box">
                            <div class="card-body text-center h-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                                <h1 class="m"><i class="fa fa-bitcoin"></i><span id="btc-balance" class="btcCoin">{{ Auth()->user()->userCoin->btcCoinAmount }}</span></h1>
                                <h3 class="font-extra-bold m-xs text-success">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" data-toggle="modal" data-target="#deposit" class="ladda-button btn btn-primary btn-block waves-effect" data-style="zoom-in"><span class="ladda-label">Deposit</span><span class="ladda-spinner"></span></button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" data-toggle="modal" data-target="#withdraw" class="ladda-button btn btn-primary btn-block waves-effect" id="getBtccoin" data-style="zoom-in"><span class="ladda-label">WithDraw</span><span class="ladda-spinner"></span></button>
                                        </div>
                                    </div>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
		<div class="box">
                    <div class="box-header">
                        BTC Tranfer
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
                                            <td>{{ $wallet->type }}</td>
                                            <td>
                                                    @if($wallet->inOut=='in')
                                                            <span class="glyphicon glyphicon-log-in text-primary"></span>
                                                    @endif
                                            </td>
                                            <td>
                                                    @if($wallet->inOut=='out')
                                                            <span class="glyphicon glyphicon-log-out text-danger"></span>
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
                                    <h5 for="qrcode" style="font-weight: 600; color:#34495e">Your BTC Wallet address</h5>
                                    <h6 class="wallet-address"></h6>
                                    <h5 for="qrcode" style="font-weight: 600; color: #34495e; margin-bottom: 0px">BTC Wallet link</h5>
                                    <a class="link-blockchain" href="" target="_blank">blockchain</a>, <a class="link-blockexplorer" href="" target="_blank">blockexplorer</a>
                                    <center><div id="qrcode" style="padding-bottom: 10px;"></div></center>
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
                <h4 class="modal-title">WithRaw</h4>
              </div>
              <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    {{ Form::number('withdrawAmount', '', array('class' => 'form-control input-sm', 'step' => '0.1', 'placeholder' => "Bitcoin amount E.g. 0.1")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    {{ Form::text('walletAddress', '', array('class' => 'form-control input-sm', 'placeholder' => "Bitcoin address E.g. 1HB5XMLmzFVj8ALj6mfBsbifRoD4miY36v")) }}
                            </div>
                            <br>
                            <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    {{ Form::number('withdrawOPT', '', array('class' => 'form-control input-sm', 'placeholder' => "OTP Code E.g. 123456")) }}
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
        <script src="{{ URL::to("js/qrcode.min.js") }}"></script>
            
	<script>
            var getBtcCoin = setInterval(function(){
                getBtccoin();
            },{{ config("app.time_interval")}});
            //get wallet code and render code to qrcode
            $.ajax({
                url: "{{ url('wallets/deposit') }}?action=btc",
            }).done(function(data) {
                if (!data.err) {
                    $(".wallet-address").html(data.walletAddress);
                    $(".link-blockchain").attr("href","https://blockchain.info/address/"+data.walletAddress);
                    $(".link-blockexplorer").attr("href","https://blockexplorer.com/address/"+data.walletAddress);
                    var qrcode = new QRCode(document.getElementById("qrcode"), {
                        text: data.walletAddress,
                        colorDark : "#000000",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });
                } else {
                    $(".wallet-address").html(data.err);
                }
            });
            
            function getBtccoin(){
                $.get( "getbtccoin", function( data ) {
                    $( ".btcCoin" ).html( data );
                });
            };
            
	</script>
@endsection