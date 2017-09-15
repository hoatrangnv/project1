@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::wallet.withdraw_btc') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body" style="padding-top:0;">
					<br>
					{{ Form::open(array('url' => 'wallets/btcwithdraw')) }}
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						{{ Form::text('withdrawAmount', '', array('class' => 'form-control input-sm', 'placeholder' => "Bitcoin amount E.g. 0.1")) }}
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon">@</span>
						{{ Form::text('walletAddress', '', array('class' => 'form-control input-sm', 'placeholder' => "Bitcoin address E.g. 1HB5XMLmzFVj8ALj6mfBsbifRoD4miY36v")) }}
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						{{ Form::text('withdrawOPT', '', array('class' => 'form-control input-sm', 'placeholder' => "OTP Code E.g. 123456")) }}
					</div>
					<br>
					{{ Form::submit(trans('adminlte_lang::wallet.bnt_otp'), array('class' => 'btn btn-success btn-block')) }}
					{{ Form::submit(trans('adminlte_lang::wallet.btn_withdraw'), array('class' => 'btn btn-primary btn-block')) }}
					{{ Form::close() }}
				</div>
			</div>
			<div class="box">
				<div class="box-header">
					<h4>BTC Withdrawal History</h4>
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
							<th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
							<th>{{ trans('adminlte_lang::wallet.withdraw_address') }}</th>
							<th>{{ trans('adminlte_lang::wallet.withdraw_amountUSD') }}</th>
							<th>{{ trans('adminlte_lang::wallet.withdraw_amountBTC') }}</th>
							<th>{{ trans('adminlte_lang::wallet.withdraw_fee') }}</th>
							<th>{{ trans('adminlte_lang::wallet.withdraw_status') }}</th>
						</tr>
						<tbody>
						@foreach ($withdraws as $key => $withdraw)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $withdraw->created_at }}</td>
								<td>{{ $withdraw->walletAddress }}</td>
								<td>{{ $withdraw->amountUSD }}</td>
								<td>{{ $withdraw->amountBTC }}</td>
								<td>{{ number_format($withdraw->fee,8) }}</td>
								<td>{{ $withdraw->status }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection