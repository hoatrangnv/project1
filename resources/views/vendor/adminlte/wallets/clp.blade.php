@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::wallet.clp') }}
@endsection

@section('main-content')
    <style>
        tr.selected {
            background-color: #5bc0de!important;
        }
        tr.checked {
            background-color: #d9edf7!important;
        }
    </style>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                                    </th>
                                    <th class="wallet-amount"><i class="fa fa-money" aria-hidden="true"></i>{{ Auth()->user()->userCoin->clpCoinAmount }}  </th>
                                    <th>
                                    <a href="{{ url('wallets/buysellclp') }}" class="btn bg-olive">{{ trans('adminlte_lang::wallet.sell_clp') }}</a>
                                    <a href="#" class="btn bg-olive" data-toggle="modal" data-target="#buy-package">Buy package</a>
                                    <a href="#" class="btn bg-olive" data-toggle="modal" data-target="#withdraw">{{ trans("adminlte_lang::wallet.withdraw") }}</a>
                                    <a href="#" class="btn bg-olive" data-toggle="modal" data-target="#deposit">{{ trans("adminlte_lang::wallet.deposit") }}</a>
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
                        <tr>
                            <th>{{ trans('adminlte_lang::package.name') }}</th>
                            <th>{{ trans('adminlte_lang::package.price') }}</th>
                        </tr>
                        <tbody>
                        @foreach ($packages as $package)
                            <tr{{ Auth::user()->userData->packageId > 0 && $package->id == Auth::user()->userData->packageId ?  ' class=checked':'' }} data-id="{{ $package->pack_id }}">
                                <td>{{ $package->name }}</td>
                                <td>${{ $package->price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="packageId" id="packageId" value="{{ Auth::user()->userData->packageId }}">
                    <button class="btn btn-success btn-block" id="btn_submit">{{ trans('adminlte_lang::wallet.buy_package') }}</button>
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
            <h4 class="modal-title">WithRaw</h4>
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
    <script>
        var packageId = {{ Auth::user()->userData->packageId }};
        var packageIdPick = packageId;
        $(document).ready(function () {
            $('#myTable tbody').on( 'click', 'tr', function () {
                var _packageId = parseInt($(this).data('id'));
                if(_packageId < packageId) {
                    $('#msg_package').html("<div class='alert alert-danger'>You cant not downgrate package.</div>");
                }else if(_packageId == packageId){
                    $('#msg_package').html("<div class='alert alert-danger'>You purchased this package.</div>");
                }else{
                    $('#myTable tbody tr').removeClass('selected');
                    $(this).addClass('selected');
                    $("#packageId").val(_packageId);
                    packageIdPick = _packageId;
                }
            });
            $('#btn_submit').on('click', function () {
                if(packageIdPick > packageId) {
                    $('#formPackage').submit();
                }else{
                    alert('You cant not this package');
                }
            });
        });
        
        $.ajax({
            url: "{{ url('wallets/deposit') }}?action=clp",
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
    </script>
@endsection