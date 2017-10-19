@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::wallet.clp') }}
@endsection

@section('main-content')
    <style>
        #myTable tbody tr:hover {
            background-color: #f5f5f5;
            cursor : pointer;
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
    @include('adminlte::layouts.wallet')
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
                                    <th class="wallet-amount"><span class="icon-clp-icon" style="font-size: 16px;"></span>{{ number_format(Auth()->user()->userCoin->clpCoinAmount, 2) }}  </th>
                                    <th style="min-width: 500px;">
                                    <a href="#" class="btn bg-olive" data-toggle="modal" data-target="#sell">{{ trans('adminlte_lang::wallet.sell_clp') }}</a>
                                    <a href="#" class="btn bg-olive" data-toggle="modal" data-target="#buy-package">{{ trans("adminlte_lang::wallet.buy_package") }}</a>
                                    @if($active)
                                        <a href="#" class="btn bg-olive" data-toggle="modal" data-target="#withdraw">{{ trans("adminlte_lang::wallet.withdraw") }}</a>
                                    @else
                                        <a href="#" class="btn bg-olive" disabled="true">{{ trans("adminlte_lang::wallet.withdraw") }}</a>
                                    @endif
                                    @if($active)
                                        <a href="#" class="btn bg-olive" data-toggle="modal" data-target="#deposit">{{ trans("adminlte_lang::wallet.deposit") }}</a>
                                    @else
                                        <a href="#" class="btn bg-olive" disabled="true">{{ trans("adminlte_lang::wallet.deposit") }}</a>
                                    @endif
                                    @if($active)
                                        <button class="btn bg-olive" data-toggle="modal"
                                            data-target="#tranfer">{{trans("adminlte_lang::wallet.transfer")}}</button>
                                    @else
                                        <button class="btn bg-olive" data-toggle="modal"
                                            disabled="true" >{{trans("adminlte_lang::wallet.transfer")}}</button>
                                    @endif
                                    
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
                    <div class="col-xs-6 col-md-2 col-lg-2">
                        {{ Form::select('wallet_type', $wallet_type, ($requestQuery && isset($requestQuery['type']) ? $requestQuery['type'] : 0), ['class' => 'form-control input-sm', 'id' => 'wallet_type']) }}
                    </div>
                    <div class="col-xs-6 col-md-2 col-lg-2">
                        {!! Form::button('Filter', ['class' => 'btn btn-sm btn-primary', 'id' => 'btn_filter']) !!}
                        {!! Form::button('Clear', ['class' => 'btn btn-sm bg-olive', 'id' => 'btn_filter_clear']) !!}
                    </div>
                </div>
                <div class="box-body table-responsive" style="padding-top:0;">
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
                                        +{{ number_format($wallet->amount, 2) }}
                                    @endif
                                </td>
                                <td>
                                    @if($wallet->inOut=='out')
                                        -{{ number_format($wallet->amount, 2) }}
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Sell CLP&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default maxsellclp"
                                                                               data-type="maxsellclp">{{ number_format(Auth()->user()->userCoin->clpCoinAmount, 2) }}</a>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="icon-clp-icon"></span></span>
                                    {{ Form::number('clpAmount', '', array('class' => 'form-control input-sm switch-CLP-to-BTC-sellclp clp-input','placeholder' => "CLP Amount", 'id' => 'sellCLPAmount')) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                    {{ Form::number('btcAmount', '', array('class' => 'form-control input-sm switch-BTC-to-CLP-sellclp clp-input', 'placeholder' => "BTC Amount", 'id' => 'sellBTCAmount')) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <span><i>Rate:</i><i class="clpbtcsell">{{number_format(App\ExchangeRate::getCLPBTCRate() * 0.95, 8)}}</i></span>
                    </div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{ Form::submit(trans('adminlte_lang::default.submit'), array('class' => 'btn btn-primary', 'id' => 'sell-clp')) }}
                  </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="buy-package" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Mining Package</h4>
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
                            <tr{{ Auth::user()->userData->packageId > 0 && $package->id == Auth::user()->userData->packageId ?  ' class=checked':'' }} data-id="{{ $package->pack_id }}">
                                <td>{{ $package->name }}</td>
                                <td><i class="fa fa-usd"></i>{{ number_format($package->price) }}</td>
                                <td><span class="icon-clp-icon"></span>{{ number_format($package->price / App\ExchangeRate::getCLPUSDRate(), 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label>
                            <div class="checkbox_register icheck">
                                <input type="checkbox" name="terms" id="termsPackage">
                                    <a href="/package-term-condition.html" target="_blank">Term and condition</a>
                            </div>
                        </label>
                        <span class="help-block"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="packageId" id="packageId"
                           value="{{ Auth::user()->userData->packageId }}">
                    @if( date('Y-m-d') > date('Y-m-d', strtotime(config('app.pre_sale_end'))) )
                        <button class="btn btn-success btn-block"
                            id="btn_submit" type="button">{{ trans('adminlte_lang::wallet.buy_package') }}</button>
                    @else
                        <button class="btn btn-success btn-block"
                            id="btn_submit" disabled="true" type="button">{{ trans('adminlte_lang::wallet.buy_package') }}</button>
                    @endif
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--withdrawa modal-->
    <div class="modal fade" id="withdraw" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Withdraw&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default withdrawclp" data-type="withdrawclp">{{ number_format(Auth()->user()->userCoin->clpCoinAmount, 2) }}</a></h4>
          </div>
          <div class="modal-body">
                <div class="box no-border">
                    <div class="box-body" style="padding-top:0;">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="icon-clp-icon"></span></span>
                                {{ Form::number('withdrawAmount', '', array('class' => 'form-control input-sm withdrawclpinput clp-input',  'placeholder' => "Amount CLP", 'id' => 'withdrawAmount')) }}
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                {{ Form::text('walletAddress', '', array('class' => 'form-control input-sm clp-input', 'id' => 'walletAddress',  'placeholder' => "Ethereum address E.g. 0xbHB5XMLmzFVj8ALj6mfBsbifRoD4miY36v")) }}
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {{ Form::number('withdrawOPT', '', array('class' => 'form-control input-sm clp-input', 'id' => 'withdrawOTP',  'placeholder' => "2FA code E.g. 123456")) }}
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
              <div class="pull-right">
                        <span><i>{{ trans("adminlte_lang::wallet.fee") }}:{{ config("app.fee_withRaw_CLP")}}</i></span>
                    </div>
          </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            {{ Form::submit(trans('adminlte_lang::default.submit'), array('class' => 'btn btn-primary', 'id' => 'withdraw-clp')) }}
        </div>
        </div>
        </div>
        <!-- /.modal-dialog -->
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
                        <div class="box no-border">
                            <div class="box-body">
                                <div class="form-group" style="text-align: center">
                                    <h5 for="qrcode" style="font-weight: 600; color:#34495e">Your CLP Wallet
                                        address</h5>
                                        <div class="form-group">
                                        <div class="input-group input-group-md col-xs-12 col-lg-10" style="margin: 0 auto;">
                                        <input type="text" value="{{ $walletAddress }}" class="wallet-address form-control" id="wallet-address" readonly="true">
                                        <span class="input-group-btn">
                                            @if(empty($walletAddress))
                                                <button class="btn btn-default get-clpwallet" title="Get clp wallet"
                                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing">Generate</button>
                                            @endif
                                         <button class="btn btn-default btnwallet-address" data-clipboard-target="#wallet-address" title="copy">
                                                    <i class="fa fa-clone"></i>
                                                </button>
                                        </span>
                                        </div>
                                        </div>
                                    <h5 for="qrcode" style="font-weight: 600; color: #34495e; margin-bottom: 0px">CLP
                                        Wallet link</h5>
                                    <a class="link-blockchain" href="https://etherscan.io/address/{{ $walletAddress }}" target="_blank">etherscan</a>
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
                    <h4 class="modal-title">{{ trans("adminlte_lang::wallet.transfer")}}&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default clp-amount maxclptranfer" data-type="clptranfer">{{ round(Auth()->user()->userCoin->clpCoinAmount, 2) }}</a></h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="icon-clp-icon"></span></span>
                                    {{ Form::number('clpAmount', '', array('class' => 'form-control input-sm clp-input amount-clp-tranfer',  'placeholder' => "Amount CLP", 'id' => 'clpAmount' )) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {{ Form::text('clpUsername', '', array('class' => 'form-control input-sm clp-input', 'id' => 'clpUsername','placeholder' => "Username")) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                    {{ Form::number('clpUid', '', array('class' => 'form-control input-sm clp-input', 'id' => 'clpUid', 'placeholder' => "Id", "tabindex" => "-1")) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    {{ Form::number('clpOTP', '', array('class' => 'form-control input-sm clp-input', 'id' => 'clpOTP' ,'placeholder' => "2FA Code E.g. 123456")) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{ Form::submit(trans('adminlte_lang::default.submit'), array('class' => 'btn btn-primary', 'id' => 'clptranfer')) }}
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
                setTimeout(function() {
                  $('button').tooltip('hide');
                }, 1000);
              }
            
            var clipboard = new Clipboard('.btnwallet-address');
            clipboard.on('success', function(e) {
                e.clearSelection();
                setTooltip('Copied!');
                hideTooltip();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var mytimer;
            $('#clpUid').on('blur onmouseout keyup', function () {
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
                                $("#clpUid").parents("div.form-group").addClass('has-error');
                                $("#clpUid").parents("div.form-group").find('.help-block').text('The Id is required');
                                $('#clpUsername').val('');
                            }else{
                                $('#clpUid').parent().removeClass('has-error');
                                $("#clpUid").parents("div.form-group").find('.help-block').text('');
                                $('#clpUsername').parent().removeClass('has-error');
                                $('#clpUsername').parent().find('.help-block').text('');
                                $('#clpUsername').val(data.username);
                            }
                        });
                    }, 1000);
                }
            });

            $('#clpUsername').on('blur onmouseout onfocusout keyup', function () {
                clearTimeout(mytimer);
                var search = $(this).val();
                if(search.length >= 3){
                    mytimer = setTimeout(function(){
                        $('#clpUid').parents("div.form-group").find('.fa-id-card-o').remove();
                        $('#clpUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-spinner"></i>');
                        $.ajax({
                            type: "GET",
                            url: "/users/search",
                            data: {username : search}
                        }).done(function(data){
                            $('#clpUid').parents("div.form-group").find('.fa-spinner').remove();
                            $('#clpUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-id-card-o"></i>');
                            if(data.err) {
                                $("#clpUsername").parents("div.form-group").addClass('has-error');
                                $("#clpUsername").parents("div.form-group").find('.help-block').text(data.err);
                                $('#clpUid').val('');
                            }else{
                                $('#clpUsername').parents("div.form-group").removeClass('has-error');
                                $("#clpUsername").parents("div.form-group").find('.help-block').text('');
                                $('#clpUid').parents("div.form-group").removeClass('has-error');
                                $('#clpUid').parents("div.form-group").find('.help-block').text('');
                                $('#clpUid').val(data.id);
                            }
                        }).fail(function (){
                            $('#tranfer').modal('hide');
                            swal("Some things wrong!");
                        });
                    }, 1000);
                }
            });

            $('.clp-input').on('keyup', function () {
                $(this).parents("div.form-group").removeClass('has-error');
                $(this).parents("div.form-group").find('.help-block').text('')
            }); 


            $('#withdraw-clp').on('click', function () {
                var withdrawAmount = $('#withdrawAmount').val();
                var walletAddress = $('#walletAddress').val();
                var withdrawOTP = $('#withdrawOTP').val();

                if($.trim(withdrawAmount) == ''){
                    $("#withdrawAmount").parents("div.form-group").addClass('has-error');
                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
                }else{
                    $("#withdrawAmount").parents("div.form-group").removeClass('has-error');
                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(walletAddress) == ''){
                    $("#walletAddress").parents("div.form-group").addClass('has-error');
                    $("#walletAddress").parents("div.form-group").find('.help-block').text("Ethereum Address is required");
                }else{
                    if(/^(0x)?[0-9a-fA-F]{40}$/.test(walletAddress) == false) {
                        $("#walletAddress").parents("div.form-group").addClass('has-error');
                        $("#walletAddress").parents("div.form-group").find('.help-block').text("Ethereum Address is not valid");
                    } else {
                        $("#walletAddress").parents("div.form-group").removeClass('has-error');
                        $("#walletAddress").parents("div.form-group").find('.help-block').text('');
                    }
                }
                    
                
                if($.trim(withdrawOTP) == ''){
                    $("#withdrawOTP").parents("div.form-group").addClass('has-error');
                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.otp_required')}}");
                }else{
                    $("#withdrawOTP").parents("div.form-group").removeClass('has-error');
                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text('');
                }

                if($.trim(withdrawAmount) != '' && $.trim(walletAddress) != '' && $.trim(withdrawOTP) != ''){
                    $('#withdraw-clp').attr('disabled', true);
                    $.ajax({
                        method : 'POST',
                        url: "{{ url('wallets/clpwithdraw') }}",
                        data: {withdrawAmount: withdrawAmount, walletAddress: walletAddress, withdrawOTP: withdrawOTP}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.withdrawAmountErr !== '') {
                                    $("#withdrawAmount").parents("div.form-group").addClass('has-error');
                                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text(data.msg.withdrawAmountErr);
                                }else {
                                    $("#withdrawAmount").parents("div.form-group").removeClass('has-error');
                                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text('');
                                }

                                if(data.msg.walletAddressErr !== '') {
                                    $("#walletAddress").parents("div.form-group").addClass('has-error');
                                    $("#walletAddress").parents("div.form-group").find('.help-block').text(data.msg.walletAddressErr);
                                }else {
                                    $("#walletAddress").parents("div.form-group").removeClass('has-error');
                                    $("#walletAddress").parents("div.form-group").find('.help-block').text('');
                                }

                                if(data.msg.withdrawOTPErr !== '') {
                                    $("#withdrawOTP").parents("div.form-group").addClass('has-error');
                                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text(data.msg.withdrawOTPErr);
                                }else {
                                    $("#withdrawOTP").parents("div.form-group").removeClass('has-error');
                                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text('');
                                }

                                $('#withdraw-clp').attr('disabled', false);
                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#withdraw-clp').attr('disabled', false);
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });

            
            $('#sell-clp').on('click', function () {
                var clpAmount = $('#sellCLPAmount').val();
                var btcAmount = $('#sellBTCAmount').val();
                if($.trim(clpAmount) == ''){
                    $("#sellCLPAmount").parents("div.form-group").addClass('has-error');
                    $("#sellCLPAmount").parents("div.form-group").find('.help-block').text("CLP Amount is required");
                }else{
                    $("#sellCLPAmount").parents("div.form-group").removeClass('has-error');
                    $("#sellCLPAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(btcAmount) == ''){
                    $("#sellBTCAmount").parents("div.form-group").addClass('has-error');
                    $("#sellBTCAmount").parents("div.form-group").find('.help-block').text("BTC Amount is required");
                }else{
                    $("#sellBTCAmount").parents("div.form-group").removeClass('has-error');
                    $("#sellBTCAmount").parents("div.form-group").find('.help-block').text('');
                }
                
                if($.trim(clpAmount) != '' && $.trim(btcAmount) != ''){
                    $.ajax({
                        method : 'POST',
                        url: "{{ url('wallets/sellclp') }}",
                        data: {clpAmount: clpAmount, btcAmount: btcAmount}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.clpAmountErr !== '') {
                                    $("#sellCLPAmount").parents("div.form-group").addClass('has-error');
                                    $("#sellCLPAmount").parents("div.form-group").find('.help-block').text(data.msg.clpAmountErr);
                                }else {
                                    $("#sellCLPAmount").parents("div.form-group").removeClass('has-error');
                                    $("#sellCLPAmount").parents("div.form-group").find('.help-block').text('');

                                    $("#sellBTCAmount").parents("div.form-group").removeClass('has-error');
                                    $("#sellBTCAmount").parents("div.form-group").find('.help-block').text('');
                                }

                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });

            $('#clptranfer').on('click', function () {
                var clpAmount = $('#clpAmount').val();
                var clpUsername = $('#clpUsername').val();
                var clpOTP = $('#clpOTP').val();
                var clpUid = $('#clpUid').val();
                if($.trim(clpAmount) == ''){
                    $("#clpAmount").parents("div.form-group").addClass('has-error');
                    $("#clpAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
                }else{
                    $("#clpAmount").parents("div.form-group").removeClass('has-error');
                    $("#clpAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(clpUsername) == ''){
                    $("#clpUsername").parents("div.form-group").addClass('has-error');
                    $("#clpUsername").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.username_required') }}");
                }else{
                    $("#clpUsername").parents("div.form-group").removeClass('has-error');
                    $("#clpUsername").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(clpUid) == ''){
                    $("#clpUid").parents("div.form-group").addClass('has-error');
                    $("#clpUid").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.uid_required')}}");
                }else{
                    $("#clpUid").parents("div.form-group").removeClass('has-error');
                    $("#clpUid").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(clpOTP) == ''){
                    $("#clpOTP").parents("div.form-group").addClass('has-error');
                    $("#clpOTP").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.otp_required')}}");
                }else{
                    $("#clpOTP").parents("div.form-group").removeClass('has-error');
                    $("#clpOTP").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(clpAmount) != '' && $.trim(clpUsername) != '' && $.trim(clpOTP) != ''){
                    $.ajax({
                        url: "{{ url('wallets/clptranfer') }}",
                        data: {clpAmount: clpAmount, clpUsername: clpUsername, clpOTP: clpOTP, clpUid: clpUid}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.clpAmountErr !== '') {
                                    $("#clpAmount").parents("div.form-group").addClass('has-error');
                                    $("#clpAmount").parents("div.form-group").find('.help-block').text(data.msg.clpAmountErr);
                                }else {
                                    $("#clpAmount").parents("div.form-group").removeClass('has-error');
                                    $("#clpAmount").parents("div.form-group").find('.help-block').text('');
                                }

                                if(data.msg.clpUsernameErr !== '') {
                                    $("#clpUsername").parents("div.form-group").addClass('has-error');
                                    $("#clpUsername").parents("div.form-group").find('.help-block').text(data.msg.clpUsernameErr);
                                }else {
                                    if(data.msg.transferRuleErr !== '') {
                                        $("#clpUsername").parents("div.form-group").addClass('has-error');
                                        $("#clpUsername").parents("div.form-group").find('.help-block').text(data.msg.transferRuleErr);
                                    } else {
                                        $("#clpUsername").parents("div.form-group").removeClass('has-error');
                                        $("#clpUsername").parents("div.form-group").find('.help-block').text('');
                                    }
                                }

                                if(data.msg.clpUidErr !== '') {
                                    $("#clpUid").parents("div.form-group").addClass('has-error');
                                    $("#clpUid").parents("div.form-group").find('.help-block').text(data.msg.clpUidErr);
                                }else {
                                    $("#clpUid").parents("div.form-group").removeClass('has-error');
                                    $("#clpUid").parents("div.form-group").find('.help-block').text('');
                                }

                                if(data.msg.clpOTPErr !== '') {
                                    $("#clpOTP").parents("div.form-group").addClass('has-error');
                                    $("#clpOTP").parents("div.form-group").find('.help-block').text(data.msg.clpOTPErr);
                                }else {
                                    $("#clpOTP").parents("div.form-group").removeClass('has-error');
                                    $("#clpOTP").parents("div.form-group").find('.help-block').text('');
                                }
                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });
        });
        var mytimer;
        
        var packageId = {{ Auth::user()->userData->packageId }};
        var packageIdPick = packageId;
        $(document).ready(function () {
            $('#myTable tbody').on('click', 'tr', function () {
                var _packageId = parseInt($(this).data('id'));
                if (_packageId > 0) {
                    if (_packageId < packageId) {
                        $('#msg_package').html("<div class='alert alert-danger'>You can not downgrade package.</div>");
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
                if(!$('#termsPackage').is(':checked')){
                    $("#termsPackage").parents("div.form-group").addClass('has-error');
                    $("#termsPackage").parents("div.form-group").find('.help-block').text('Please checked term');
                    return false;
                }else{
                    $("#termsPackage").parents("div.form-group").removeClass('has-error');
                    $("#termsPackage").parents("div.form-group").find('.help-block').text('');
                    if (packageIdPick > packageId) {
                        swal({
                          title: "Are you sure?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-info",
                          confirmButtonText: "Yes, buy it!",
                          closeOnConfirm: false
                        },
                        function(){
                          $('#formPackage').submit();
                        });
                        
                    } else {
                        swal('You select invalid package')
                        return false;
                    }
                }

            });
        });

        var qrcode = new QRCode(document.getElementById("qrcode"), {
                    width: 180,
                    height: 180,
                    text: '{{ $walletAddress }}',
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });


        $(".switch-BTC-to-CLP-sellclp").on('keyup change mousewheel', function () {
            var value = $(this).val();
            var result = value / (globalCLPBTC * 0.95) ;
            $(".switch-CLP-to-BTC-sellclp").val(result.toFixed(2));
        });

        $(".switch-CLP-to-BTC-sellclp").on('keyup change mousewheel', function () {
            var value = $(this).val();
            var result = value * globalCLPBTC * 0.95;
            $(".switch-BTC-to-CLP-sellclp").val(result.toFixed(5));
        });

        //get total value;
        var data = {{ Auth()->user()->userCoin->clpCoinAmount }};

        $(".maxsellclp").click(function () {
            $(".switch-CLP-to-BTC-sellclp").val(data)
            var result = data * globalCLPBTC;
            $(".switch-BTC-to-CLP-sellclp").val(result.toFixed(5));
        });

        $(".withdrawclp").click(function () {
            $(".withdrawclpinput").val(data)
        });

        $( ".maxclptranfer" ).click(function() {
            $(".amount-clp-tranfer").val($(".clp-amount").html());
        });

        //get address wallet
        $(".get-clpwallet").click(function(){
            $(".get-clpwallet").attr("disabled", "disabled");
            var $this = $(this);
            $this.button('loading');
            $.get("{{URL::to('wallets/clp/getaddressclpwallet')}}", function(data, status){
                if (data.err){
                    alert("{{trans('adminlte_lang::wallet.not_get_address_clp_wallet')}}");
                    $this.button('reset');
                    $(".get-clpwallet").removeAttr("disabled");
                }else{
                    $("#wallet-address").val(data.data);
                    $(".get-clpwallet").hide();
                }
            }).fail(function () {
                console.log("Error response!")
            });
        });
    </script>
@endsection