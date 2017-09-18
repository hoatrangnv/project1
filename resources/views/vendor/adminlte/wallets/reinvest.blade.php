@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.reinvest') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
                            <div class="box-header">
                                    <a href="{{ url('wallets/buyclp') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.buy_clp') }}</a>
                            </div>
                            <div class="box-body" style="padding-top:0;">
                                <div class="table-responsive">
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
                                </div>
                                <div class="text-center">
                                        {{ $wallets->links() }}
                                </div>
                            </div>
			</div>
		</div>
	</div>
@endsection