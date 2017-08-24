@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title') }}
@endsection

@section('main-content')
	 <a href="{{ URL::to('roles/create') }}" class="btn btn-success">Add Role</a>
	<a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
    <br>
    <br>
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">{{ trans('adminlte_lang::permissions.header_title') }}</h3>
				</div>
				<div class="box-body">
					{{-- @include ('errors.list') --}}
					{{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
					<div class="form-group">
						{{ Form::label('name', 'Role Name') }}
						{{ Form::text('name', null, array('class' => 'form-control')) }}
					</div>
					<h5><b>Assign Permissions</b></h5>
					<div class='form-group'>
						@foreach ($permissions as $permission)
							{{ Form::checkbox('permissions[]',  $permission->id , $role->permissions) }}
							{{ Form::label($permission->name, ucfirst($permission->name)) }}<br>
						@endforeach
					</div>
					{{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection