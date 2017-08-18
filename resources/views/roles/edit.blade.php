@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::role.header_title') }}
@endsection
@section('contentheader_description')
	{{ trans('adminlte_lang::role.edit') }}
@endsection

@section('main-content')
	{{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box box-info">
				<div class="box-body">
					{{-- @include ('errors.list') --}}
					<div class="form-group">
						{{ Form::label('name', trans('adminlte_lang::role.title')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('name', null, array('class' => 'form-control input-sm')) }}
						</div>
					</div>
					<div class='form-group'>
						<label class="col-sm-2 control-label" for="inputStatus">Assign Permissions</label>
						<div class="col-sm-10">
							@foreach ($permissions as $permission)
								{{ Form::checkbox('permissions[]',  $permission->id , $role->permissions) }}
								{{ Form::label($permission->name, ucfirst($permission->name)) }}<br>
							@endforeach
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputStatus"> </label>
						<div class="col-sm-10">
							{{ Form::submit(trans('adminlte_lang::default.btn_edit'), array('class' => 'btn btn-primary')) }}
						</div>
					</div>
				</div>
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection