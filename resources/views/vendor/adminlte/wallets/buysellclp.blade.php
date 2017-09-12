@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::wallet.buy_clp') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-4">
			<div class="box">
				<div class="box-header">
					<h3 class="no-margin">Buy CLP Coin with BTC Coin</h3>
				</div>
				<div class="box-body" style="padding-top:0;">
					{{ Form::open(array('url' => 'wallets/buyclpbybtc')) }}
					<div class="input-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						{{ Form::text('amount', '', array('class' => 'form-control input-sm', 'placeholder' => "USD amount E.g. 0.1")) }}
						@if ($errors->has('amount'))
							<span class="help-block">
								{{ $errors->first('amount') }}
							</span>
						@endif
					</div>
					<br>
					{{ Form::submit(trans('adminlte_lang::wallet.btn_withdraw'), array('class' => 'btn btn-primary btn-block')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="box">
				<div class="box-header">
					<h3 class="no-margin">Sell CLP Coin with BTC Coin</h3>
				</div>
				<div class="box-body" style="padding-top:0;">
					{{ Form::open(array('url' => 'wallets/selclpbybtc')) }}
					<div class="input-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						{{ Form::text('amount', '', array('class' => 'form-control input-sm', 'placeholder' => "USD amount E.g. 0.1")) }}
						@if ($errors->has('amount'))
							<span class="help-block">
								{{ $errors->first('amount') }}
							</span>
						@endif
					</div>
					<br>
					{{ Form::submit(trans('adminlte_lang::wallet.btn_withdraw'), array('class' => 'btn btn-primary btn-block')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="box">
				<div class="box-header">
					<h3 class="no-margin">Buy CLP Coin with USD</h3>
				</div>
				<div class="box-body" style="padding-top:0;">
					{{ Form::open(array('url' => 'wallets/buyclp')) }}
					<div class="input-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						{{ Form::text('amount', '', array('class' => 'form-control input-sm', 'placeholder' => "USD amount E.g. 0.1")) }}
						@if ($errors->has('amount'))
							<span class="help-block">
								{{ $errors->first('amount') }}
							</span>
						@endif
					</div>
					<br>
					{{ Form::submit(trans('adminlte_lang::wallet.btn_withdraw'), array('class' => 'btn btn-primary btn-block')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@endsection