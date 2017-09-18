@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::wallet.usd') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer">
              <div class="row">
                  <div class="col-sm-3 border-right" style="text-align: center">
                      <div class="description-header" style="margin-top: 6px">  
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                    </div>
                  <!-- /.description-block -->
                </div>  
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header">
                        @isset($wallets->currencyPair){{ $wallets->currencyPair->last/10 }}$ @endisset
                    </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header">0.1b /</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3">
                  <div class="description-block">
                    <h5 class="description-header">500CLP</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
        <div class="col-md-5">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header">1 CLP =</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header">0.0000043 BTC =</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3">
                  <div class="description-block">
                    <h5 class="description-header">1000 $</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
        <div class="col-md-2">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user" style="text-align: center">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-footer">
                <button class="btn btn-success">{{ trans('adminlte_lang::wallet.tranfer_to_clp') }}</button>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                        <!--a href="{{ route('packages.invest') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.buy_package') }}</a-->
                        <a href="{{ url('wallets/buysellclp') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.buy_clp') }}</a>
                </div>
                <div class="box-body" style="padding-top:0;">
                    <table class="table table-bordered table-hover table-striped dataTable">
                        <tr>
                            <th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.wallet_type') }}</th>
                            <th>{{ trans('adminlte_lang::wallet.amount') }}</th>
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
                                    @if($wallet->type==1)
                                            Buy CLP Coin
                                        @elseif($wallet->type==3)
                                            Bonus Day
                                        @endif
                                </td>
                                <td>{{ $wallet->amount }}</td>
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
@endsection