@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::package.manager') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@if (session('flash_message'))
				<div class="alert alert-success">
					{{ session('flash_message') }}
				</div>
			@endif
			<div class="box">
				<div class="box-header">
					<h4>Buy investment Package</h4>
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::package.name') }}</th>
							<th>{{ trans('adminlte_lang::package.price') }}</th>
							<th>{{ trans('adminlte_lang::package.token') }}</th>
							<th>{{ trans('adminlte_lang::package.replication') }}</th>
						</tr>
						<tbody>
							 @foreach ($packages as $package)
							<tr>
								<td>{{ $package->name }}</td>
								<td>${{ $package->price }}</td>
								<td>{{ $package->token }}</td>
								<td>{{ $package->replication_time }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="box">
				<div class="box-header">
					<h4>Choose your package</h4>
				</div>
				<div class="box-body" style="padding-top:0;">
					<br>
					{{ Form::open(array('url' => 'packages/invest')) }}
						{{ Form::select('packageId', $lstPackSelect, $user->packageId, ['class' => 'form-control input-sm']) }}
					<br>
					{{ Form::submit(trans('adminlte_lang::wallet.buy_package'), array('class' => 'btn btn-success btn-block')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@endsection