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
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<a href="{{ route('packages.create') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::package.add') }}</a>
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::package.name') }}</th>
							<th>{{ trans('adminlte_lang::package.price') }}</th>
							<th>{{ trans('adminlte_lang::package.token') }}</th>
							<th>{{ trans('adminlte_lang::package.replication') }}</th>
							<th>{{ trans('adminlte_lang::package.action') }}</th>
						</tr>
						<tbody>
							 @foreach ($packages as $package)
							<tr>
								<td>{{ $package->name }}</td>
								<td>${{ $package->price }}</td>
								<td>{{ $package->token }}</td>
								<td>{{ $package->replication_time }}</td>
								<td>
								<a href="{{ URL::to('packages/'.$package->id.'/edit') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_edit') }}</a>
								{!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $package->id] ]) !!}
								{!! Form::submit(trans('adminlte_lang::default.btn_delete'), ['class' => 'btn btn-xs btn-danger']) !!}
								{!! Form::close() !!}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection