@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title') }}
@endsection

@section('main-content')
	<a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
	<a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a>
    <br>
    <br>
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">{{ trans('adminlte_lang::permissions.header_title') }}</h3>
				</div>
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Date/Time Added</th>
							<th>User Roles</th>
							<th>Operations</th>
						</tr>
						<tbody>
							@foreach ($users as $user)
							<tr>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
								<td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
								<td>
								<a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;">Edit</a>
								{!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
								{!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) !!}
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