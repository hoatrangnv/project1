@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<a href="{{ route('roles.create') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::role.add') }}</a>
					<div class="btn-group">
						<a href="{{ route('users.index') }}" class="btn btn-sm btn-default">{{ trans('adminlte_lang::user.header_title') }}</a>
						<a href="{{ route('permissions.index') }}" class="btn btn-sm btn-default">{{ trans('adminlte_lang::permission.header_title') }}</a>
					</div>
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::role.title') }}</th>
							<th>{{ trans('adminlte_lang::role.permission') }}</th>
							<th>{{ trans('adminlte_lang::role.action') }}</th>
						</tr>
						<tbody>
							 @foreach ($roles as $role)
							<tr>
								<td>{{ $role->name }}</td>
								<td>{{ $role->permissions()->pluck('name')->implode(' | ') }}</td>
								<td>
								<a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_edit') }}</a>
								{!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $user->id] ]) !!}
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