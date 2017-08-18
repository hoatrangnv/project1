@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<a href="{{ route('users.create') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::user.add') }}</a>
					<div class="btn-group">
						<a href="{{ route('roles.index') }}" class="btn btn-sm btn-default">{{ trans('adminlte_lang::role.header_title') }}</a>
						<a href="{{ route('permissions.index') }}" class="btn btn-sm btn-default">{{ trans('adminlte_lang::permission.header_title') }}</a>
					</div>
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::user.username') }}</th>
							<th>{{ trans('adminlte_lang::user.email') }}</th>
							<th>{{ trans('adminlte_lang::default.create_at') }}</th>
							<th>User Roles</th>
							<th>Operations</th>
						</tr>
						<tbody>
							@foreach ($users as $user)
							<tr>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
								<td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
								<td>
								<a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_edit') }}</a>
								{!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
								{!! Form::submit(trans('adminlte_lang::default.btn_delete'), ['class' => 'btn btn-xs btn-danger']) !!}
								{!! Form::close() !!}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
				</div>
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection