@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::wallet.reinvest') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{ route('permissions.create') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.buy_package') }}</a>
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
								<td>{{ $wallet->inOut }}</td> 
								<td>{{ $wallet->inOut }}</td> 
								<td>{{ $wallet->note }}</td> 
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection