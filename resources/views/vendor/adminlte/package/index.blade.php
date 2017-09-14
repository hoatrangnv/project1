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
			<div class="box">
				<div class="box-header">
					@can('add_users')
						<a href="{{ route('packages.create') }}" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus-sign"></i> {{ trans('adminlte_lang::package.add') }}</a>
					@endcan
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::package.name') }}</th>
							<th>{{ trans('adminlte_lang::package.price') }}</th>
							<th>{{ trans('adminlte_lang::package.token') }}</th>
							<th>{{ trans('adminlte_lang::package.replication') }}</th>
							@can('edit_packages')
							<th>{{ trans('adminlte_lang::package.action') }}</th>
							@endcan
						</tr>
						<tbody>
							 @foreach ($packages as $package)
							<tr>
								<td>{{ $package->name }}</td>
								<td>${{ $package->price }}</td>
								<td>{{ $package->token }}</td>
								<td>{{ $package->replication_time }}</td>
								@can('edit_packages')
									<td class="text-center">
										@include('shared._actions', [
                                            'entity' => 'packages',
                                            'id' => $package->id
                                        ])
									</td>
								@endcan
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