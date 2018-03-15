@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('main-content')

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
            <div class="box">

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped wallet-table">
                            <tr>
                                <th class="icon-wallet">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                                </th>
                                <th class="wallet-amount">
                                    @isset($wallets->currencyPair)<i class="fa fa-usd" aria-hidden="true"></i><span class="usd-amount">{{ number_format($wallets->currencyPair, 2) }}</span>  @endisset
                                </th>
                                <th>
                                    <button class="btn bg-olive" data-toggle="modal" data-target="#modal-buyCLP">{{ trans('adminlte_lang::general.btn_buy_clp') }}</button>
                                    <button class="btn bg-olive" data-toggle="modal" data-target="#modal-transferandbuyUSD">{{ trans('adminlte_lang::general.btn_transfer_and_buy') }}</button>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
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
                        {!! Form::button(Lang::get('adminlte_lang::wallet.filter'), ['class' => 'btn btn-sm btn-primary', 'id' => 'btn_filter']) !!}
                        {!! Form::button(Lang::get('adminlte_lang::wallet.clear'), ['class' => 'btn btn-sm bg-olive', 'id' => 'btn_filter_clear']) !!}
                    </div>
                </div>
                <div class="box-body" style="padding-top:0;">
                    <div class="table-responsive">
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
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>
                                    {{ $wallet->created_at }}
                                </td> 
                                <td>
                                    {{ $wallet_type && isset($wallet_type[$wallet->type]) ? $wallet_type[$wallet->type] : '' }}
                                </td>
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
                                <td>
                                    {{ $wallet->note }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="text-center">
                        {{ $wallets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-buyCLP">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        {{ trans('adminlte_lang::wallet.tranfer_to_clp') }}&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-default max usd-amount" data-type="usdwallet">${{ number_format($wallets->currencyPair,2) }}</a>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                {{ Form::number('usdAmount', '', ['class' => 'form-control input-sm switch-USD-to-CLP clp-input', 'id' => 'usdAmount', 'placeholder' => trans('adminlte_lang::wallet.usd_amount')] ) }}
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="icon-clp-icon"></span></span>
                                {{ Form::number('clpAmount', '', ['class' => 'form-control input-sm switch-CLP-to-USD clp-input', 'id' => 'clpAmount', 'placeholder' => trans('adminlte_lang::wallet.clp_amount')] ) }}
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button(trans('adminlte_lang::general.btn_close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) }}
                    {{ Form::submit(trans('adminlte_lang::default.submit'), ['class' => 'btn btn-primary', 'id' => 'buyCLP']) }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-transferandbuyUSD">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        {{ trans("adminlte_lang::general.btn_transfer_and_buy")}}&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-default max usd-amount" data-type="usdwallet">${{ number_format($wallets->currencyPair,2) }}</a>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border">
                        <div class="box-body" style="padding-top:0;">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {{ Form::text('trfUsername', '', ['class' => 'form-control input-sm trf-input', 'id' => 'trfUsername','placeholder' => trans('adminlte_lang::wallet.username'), 'autofocus']) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                    {{ Form::number('trfUid', '', ['class' => 'form-control input-sm trf-input', 'id' => 'trfUid', 'placeholder' => trans('adminlte_lang::wallet.userid')]) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-dollar"></span></span>
                                    {{ Form::select('trfOptions', [], '', ['class' => 'form-control select2', 'id' => 'trfOptions']) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    {{ Form::number('trfOTP', '', ['class' => 'form-control input-sm trf-input', 'id' => 'trfOTP', 'placeholder' => trans('adminlte_lang::wallet.2fa_code')]) }}
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button(trans('adminlte_lang::general.btn_close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) }}
                    {{ Form::submit(trans('adminlte_lang::default.submit'), ['class' => 'btn btn-primary', 'id' => 'transferandbuyUSD']) }}
                </div>
            </div>
        </div>
    </div>

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
            });

            $('#btn_filter_clear').on('click', function () {
                location.href = '{{ url()->current() }}';
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.clp-input').on('keyup', function () {
                $(this).parents("div.form-group").removeClass('has-error');
                $(this).parents("div.form-group").find('.help-block').text('')
            });

            $('#buyCLP').on('click', function () {
                var usdAmount = $('#usdAmount').val();
                var clpAmount = $('#clpAmount').val();
                if($.trim(clpAmount) == ''){
                    $("#clpAmount").parents("div.form-group").addClass('has-error');
                    $("#clpAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::message.clp_amount_required')}}");
                }else{
                    $("#clpAmount").parents("div.form-group").removeClass('has-error');
                    $("#clpAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(usdAmount) == ''){
                    $("#usdAmount").parents("div.form-group").addClass('has-error');
                    $("#usdAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::message.usd_amount_required')}}");
                }else{
                    $("#usdAmount").parents("div.form-group").removeClass('has-error');
                    $("#usdAmount").parents("div.form-group").find('.help-block').text('');
                }
                
                if($.trim(clpAmount) != '' && $.trim(usdAmount) != ''){
                    $.ajax({
                        method : 'POST',
                        url: "{{ route('usd.buyclp') }}",
                        data: {clpAmount: clpAmount, usdAmount: usdAmount}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.usdAmount !== '') {
                                    $("#usdAmount").parents("div.form-group").addClass('has-error');
                                    $("#usdAmount").parents("div.form-group").find('.help-block').text(data.msg.usdAmountErr);
                                }else {
                                    $("#usdAmount").parents("div.form-group").removeClass('has-error');
                                    $("#usdAmount").parents("div.form-group").find('.help-block').text('');
                                }

                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#tranfer').modal('hide');
                        swal("{{ trans('adminlte_lang::message.something_goes_wrong') }}");
                    });
                }
            });

            $('#transferandbuyUSD').on('click', function () {
                var trfUsername = $('#trfUsername').val();
                var trfUid = $('#trfUid').val();
                var trfOptions = $('#trfOptions').val();
                var trfOTP = $('#trfOTP').val();
                if($.trim(trfUsername) == ''){
                    $("#trfUsername").parents("div.form-group").addClass('has-error');
                    $("#trfUsername").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.username_required') }}");
                }else{
                    $("#trfUsername").parents("div.form-group").removeClass('has-error');
                    $("#trfUsername").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(trfUid) == ''){
                    $("#trfUid").parents("div.form-group").addClass('has-error');
                    $("#trfUid").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.uid_required') }}");
                }else{
                    $("#trfUid").parents("div.form-group").removeClass('has-error');
                    $("#trfUid").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(trfOptions) == ''){
                    $("#trfOptions").parents("div.form-group").addClass('has-error');
                    $("#trfOptions").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.select_an_option') }}");
                }else{
                    $("#trfOptions").parents("div.form-group").removeClass('has-error');
                    $("#trfOptions").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(trfOTP) == ''){
                    $("#trfOTP").parents("div.form-group").addClass('has-error');
                    $("#trfOTP").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.otp_required') }}");
                }else{
                    $("#trfOTP").parents("div.form-group").removeClass('has-error');
                    $("#trfOTP").parents("div.form-group").find('.help-block').text('');
                }

                $.ajax({
                    type: "GET",
                    url:"{{ url('wallets/usd/gettransferandbuypackges')}}/",
                    data: {username : trfUsername},
                }).done(function(data){
                    trfAmount = data.transferoptions[trfOptions].amount;
                    swaltitle= "{{ trans('adminlte_lang::wallet.transfer') }} $" + trfAmount + " {{ trans('adminlte_lang::wallet.to') }} " + trfUsername;
                    if(data.err) {
                        $('#tranfer').modal('hide');
                        swal("{{ trans('adminlte_lang::message.something_goes_wrong') }}");
                    } else {
                        swal({
                            title: "",
                            text: "{{ trans('adminlte_lang::wallet.transfer') }} $" + trfAmount + " {{ trans('adminlte_lang::wallet.to') }} " + trfUsername,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "{{trans('adminlte_lang::wallet.msg_sure_confirm')}}",
                            cancelButtonText: "{{trans('adminlte_lang::general.no')}}",
                            closeOnConfirm: true,
                            closeOnCancel: true,
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    method : 'POST',
                                    url: "{{ route('usd.transferusd') }}",
                                    data: {username: trfUsername, userId: trfUid, packageId: trfOptions, OTP: trfOTP}
                                }).done(function (data) {
                                    if (data.err) {
                                    } else {
                                        $('#tranfer').modal('hide');
                                        location.href = '{{ url()->current() }}';
                                    }
                                }).fail(function () {
                                    $('#tranfer').modal('hide');
                                    swal("{{ trans('adminlte_lang::message.something_goes_wrong') }}");
                                });
                            } 
                        });
                    }
                });


            });

        });

        // var getUSDAmount = setInterval(function () {
        //     $.get("getusdamount", function (data) {
        //         $(".usd-amount").html(data);
        //     });
        // },{{ config("app.time_interval")}});
        
        $( ".switch-USD-to-CLP" ).keyup(function() {
            var $this = $(this);
            var value = $(this).val();
            var result = value / globalCLPUSD;
            $(".switch-CLP-to-USD").val(result);
        });
        
        $( ".switch-CLP-to-USD" ).keyup(function() {
             var value = $(this).val();
            var result = value * globalCLPUSD;
           $(".switch-USD-to-CLP").val(result);
        });
        
        var data = {{ $wallets->currencyPair }};
        //get total value;
        $( ".max" ).click(function() {
            $(".switch-USD-to-CLP").val(data)
            var result = data / globalCLPUSD;
            $(".switch-CLP-to-USD").val(result);
        });
        
        var mytimer;
        $('#usdUid').on('blur onmouseout keyup', function () {
            clearTimeout(mytimer);
            var search = $(this).val();
            if(search.length >= 1){
                mytimer = setTimeout(function(){
                    $.ajax({
                        type: "GET",
                        url:"{{ url('wallets/usd/gettransferandbuypackges')}}/",
                        data: {id : search}
                    }).done(function(data){
                        var output = [];
                        output.push('<option value="0" disabled selected>{{trans("adminlte_lang::message.please_select_package")}}</option>');
                        if(data.err) {
                            $("#usdUid").parents("div.form-group").addClass('has-error');
                            $("#usdUid").parents("div.form-group").find('.help-block').text(data.err);
                            $('#usdUsername').val('');
                            $('#usdTransferOptions').html(output.join(''));
                        }else{
                            $('#usdUid').parent().removeClass('has-error');
                            $("#usdUid").parents("div.form-group").find('.help-block').text('');
                            $('#usdUsername').parent().removeClass('has-error');
                            $('#usdUsername').parent().find('.help-block').text('');
                            $('#usdUsername').val(data.username);
                            $('#usdTransferOptions').length = 0;
                            $.each(data.transferoptions, function(key, value) {
                                output.push('<option value="' + key + '" ' + (value.enable? '' : 'disabled') + '>' + value.text + '</option>');
                            });
                            $('#usdTransferOptions').html(output.join(''));
                        }
                    });
                }, 1000);
            }
        });


        $('#trfUsername').on('blur onmouseout onfocusout keyup', function () {
            clearTimeout(mytimer);
            var search = $(this).val();
            if(search.length >= 3){
                mytimer = setTimeout(function(){
                    $('#trfUid').parents("div.form-group").find('.fa-id-card-o').remove();
                    $('#trfUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-spinner"></i>');
                    $.ajax({
                        type: "GET",
                        url:"{{ url('wallets/usd/gettransferandbuypackges')}}/",
                        data: {username : search}
                    }).done(function(data){
                        var output = [];
                        output.push('<option value="0" disabled selected>{{trans("adminlte_lang::message.please_select_package")}}</option>');
                        $('#trfUid').parents("div.form-group").find('.fa-spinner').remove();
                        $('#trfUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-id-card-o"></i>');
                        if(data.err) {
                            $("#trfUsername").parents("div.form-group").addClass('has-error');
                            $("#trfUsername").parents("div.form-group").find('.help-block').text(data.err);
                            $('#trfUid').val('');
                            $('#trfTransferOptions').html(output.join(''));
                        }else{
                            $('#trfUsername').parents("div.form-group").removeClass('has-error');
                            $("#trfUsername").parents("div.form-group").find('.help-block').text('');
                            $('#trfUid').parents("div.form-group").removeClass('has-error');
                            $('#trfUid').parents("div.form-group").find('.help-block').text('');
                            $('#trfUid').val(data.id);
                            $('#trfTransferOptions').length = 0;
                            $.each(data.transferoptions, function(key, value) {
                                output.push('<option value="' + key + '" ' + (value.enable? '' : 'disabled') + '>' + value.text + '</option>');
                            });
                            $('#trfOptions').html(output.join(''));
                        }
                    }).fail(function (){
                        $('#tranfer').modal('hide');
                        swal("{{ trans('adminlte_lang::message.something_goes_wrong') }}");
                    });
                }, 1000);
            }
        });

        $('.trf-input').on('keyup', function () {
            $(this).parents("div.form-group").removeClass('has-error');
            $(this).parents("div.form-group").find('.help-block').text('')
        }); 
    </script>
@endsection