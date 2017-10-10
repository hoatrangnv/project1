@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('main-content')

    <!--    captrue error-->
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
                        <tr>
                            <th class="icon-wallet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                            </th>
                            <th class="wallet-amount">@isset($wallets->currencyPair)<i class="fa fa-usd" aria-hidden="true"></i><span class="usd-amount">{{ number_format($wallets->currencyPair, 2) }}</span>  @endisset</th>
                            <th><button class="btn bg-olive" data-toggle="modal" data-target="#modal-default">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}</button></th>
                        </tr>
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
                                <td>{{ $key+1 }}</td>
                                <td>{{ $wallet->created_at }}</td> 
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
    <!--fORM submit-->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default max usd-amount" data-type="usdwallet">{{ $wallets->currencyPair }}</a></h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                {{ Form::number('usdAmount', '', array('class' => 'form-control input-sm switch-USD-to-CLP clp-input', 'id' => 'usdAmount', 'placeholder' => "USD Amount")) }}
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="icon-clp-icon"></span></span>
                                {{ Form::number('clpAmount', '', array('class' => 'form-control input-sm switch-CLP-to-USD clp-input', 'id' => 'clpAmount', 'placeholder' => "CLP Amount")) }}
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="buyCLP">Submit</button>
                </div>
            </div>
          <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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
                    $("#clpAmount").parents("div.form-group").find('.help-block').text("CLP Amount is required");
                }else{
                    $("#clpAmount").parents("div.form-group").removeClass('has-error');
                    $("#clpAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(usdAmount) == ''){
                    $("#usdAmount").parents("div.form-group").addClass('has-error');
                    $("#usdAmount").parents("div.form-group").find('.help-block').text("USD Amount is required");
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
                        swal("Some things wrong!");
                    });
                }
            });

        });

        // var getUSDAmount = setInterval(function () {
        //     $.get("getusdamount", function (data) {
        //         $(".usd-amount").html(data);
        //     });
        // },{{ config("app.time_interval")}});
        
        $( ".switch-USD-to-CLP" ).keyup(function() {
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
        
    </script>
@endsection