@extends('adminlte::backend.layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::package.name') }}</th>
							<th>Total Member</th>
						</tr>
						<tbody>
							@foreach ($packages as $package)
							<tr>
								<td>{{ $package->name }}</td>
								<td>{{ $package->users->count() }}</td>
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