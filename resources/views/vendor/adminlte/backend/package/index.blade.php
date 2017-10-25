@extends('adminlte::backend.layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
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
							<th>Pack Id</th>
							<th>{{ trans('adminlte_lang::package.name') }}</th>
							<th>{{ trans('adminlte_lang::package.price') }}</th>
							<th>{{ trans('adminlte_lang::package.token') }}</th>
							@can('edit_packages')
							<th>{{ trans('adminlte_lang::package.action') }}</th>
							@endcan
						</tr>
						<tbody>
							 @foreach ($packages as $package)
							<tr>
								<td>{{ $package->pack_id }}</td>
								<td>{{ $package->name }}</td>
								<td>${{ number_format($package->price) }}</td>
								<td>{{ number_format($package->price / \App\ExchangeRate::getCLPUSDRate()) }}</td>
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