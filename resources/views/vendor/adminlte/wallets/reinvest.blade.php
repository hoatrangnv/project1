@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.reinvest') }}
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
                    <div>
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{ trans('adminlte_lang::wallet.tl_holding_amount') }}</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('adminlte_lang::wallet.tl_released_amount') }}</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active wallet-amount" id="home">
                            <div class="col-sm-12" style="padding-top: 5px;">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="position: absolute;"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg></span>
                                <span class="icon-clp-icon" style="font-size: 16px; margin-left:32px;"></span><strong>{{ number_format($wallets->currencyPair, 2) }}</strong>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane wallet-amount-released" id="profile">
                            <div class="col-sm-6" style="padding-top: 5px;">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="position: absolute;"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg></span>
                                <span class="icon-clp-icon" style="font-size: 16px; margin-left:32px;"></span><strong>{{ number_format(Auth()->user()->userCoin->availableAmount, 2) }}</strong>
                            </div>
                            <div class="col-sm-6" style="padding-left: 0px;">
                                <button class="btn bg-olive" id="btnTransfer" @if(Auth()->user()->userCoin->availableAmount == 0) disabled="true" @endif >{{ trans('adminlte_lang::wallet.btn_transfer_holding_to_clp') }}</button>
                            </div>
                        </div>
                      </div>

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
                                    <th>{{ trans('adminlte_lang::wallet.wallet_release_date') }}</th>
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
                                        <td>{{ date('Y-m-d', strtotime("+6 months", strtotime($wallet->updated_at))) }}</td> 
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
                                        <td>{{ $wallet->note }}</td>
                                        
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

            $('#btnTransfer').on('click', function() {
                swal({
                  title: "{{trans('adminlte_lang::wallet.msg_sure_confirm')}}",
                  text: '{{trans('adminlte_lang::wallet.msg_transfer_confirm')}}',
                  type: "info",
                  showCancelButton: true,
                  confirmButtonClass: "btn-blue",
                  confirmButtonText: "{{trans('adminlte_lang::wallet.btn_sure_transfer')}}",
                  showLoaderOnConfirm: true,
                  closeOnConfirm: false
                },
                function(){
                    mytimer = setTimeout(function(){
                        $.ajax({
                            type: "GET",
                            url: "{{route('holding.transfer')}}",
                            dataType: 'json',
                        }).done(function(data){
                            if(data.msg) {
                                swal(data.msg);
                            } else {
                                swal('somethings wrong!');
                            }
                        }).fail(function(){
                            swal('somethings wrong!');
                        });
                    }, 1000);
                   
                });
            });
        });

  
    </script>
@endsection
