@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.btc') }}
@endsection



@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body" style="padding-top:0;">
					<br>
					{{ Form::open(array('url' => 'wallets/btctransfer')) }}
					<div class="input-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						{{ Form::text('amount', '', array('class' => 'form-control input-sm', 'placeholder' => "Btc amount E.g. 0.1")) }}
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