@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title') }}
@endsection

@section('main-content')
	 <a href="{{ URL::to('roles/create') }}" class="btn btn-success">Add Role</a>
	<a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
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
							<th>Role</th>
							<th>Permissions</th>
							<th>{{ trans('adminlte_lang::permissions.action') }}</th>
						</tr>
						<tbody>
							 @foreach ($roles as $role)
							<tr>
								<td>{{ $role->name }}</td>
								<td>{{  $role->permissions()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
								<td>
								<a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;">Edit</a>
								{!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
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