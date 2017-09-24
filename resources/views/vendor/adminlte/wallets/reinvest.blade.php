@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.reinvest') }}
@endsection

@section('main-content')
    
    <div class="row">
        <div class="col-md-5">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer">
              <div class="row">
                  <div class="col-sm-1 border-right" style="text-align: center">
                      <div class="description-header" style="margin-top: 6px">  
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                    </div>
                  <!-- /.description-block -->
                </div>  
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header rate-usd-btc">
                        @isset($wallets->currencyPair){{ $wallets->currencyPair }} $ @endisset
                    </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
               
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <button class="btn btn-success" data-toggle="modal" data-target="#modal-default">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}</button>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
    </div>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
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
                                            @if($wallet->type == App\Wallet::FAST_START_TYPE)
                                                {{ trans('adminlte_lang::wallet.fast_start_type') }}
                                            @elseif($wallet->type == App\Wallet::INTEREST_TYPE )
                                                {{ trans('adminlte_lang::wallet.interest') }}
                                            @elseif($wallet->type == App\Wallet::BINARY_TYPE)
                                                {{ trans('adminlte_lang::wallet.binary') }}
                                            @elseif($wallet->type == App\Wallet::LTOYALTY_TYPE)
                                                {{ trans('adminlte_lang::wallet.loyalty') }}
                                            @elseif($wallet->type == App\Wallet::USD_CLP_TYPE)
                                                {{ trans('adminlte_lang::wallet.usd_clp_type') }}
                                            @elseif($wallet->type == App\Wallet::REINVEST_CLP_TYPE)
                                                {{ trans('adminlte_lang::wallet.reinvest_clp_type') }}
                                            @elseif($wallet->type == App\Wallet::BTC_CLP_TYPE)
                                                {{ trans('adminlte_lang::wallet.btc_clp_type') }}
                                            @elseif($wallet->type == App\Wallet::CLP_BTC_TYPE)
                                                {{ trans('adminlte_lang::wallet.clp_btc_type') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($wallet->inOut=='in')
                                                {{ $wallet->amount }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($wallet->inOut=='out')
                                                {{ $wallet->amount }}
                                            @endif
                                        </td>
                                        <td>
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
@endsection