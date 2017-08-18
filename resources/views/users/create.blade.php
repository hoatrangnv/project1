@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::user.add') }}
@endsection

@section('main-content')
	{{ Form::open(array('url' => 'users', 'class' => 'form-horizontal')) }}
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box box-info">
				<div class="box-body">
					{{-- @include ('errors.list') --}}
					<div class="form-group">
						{{ Form::label('name', trans('adminlte_lang::user.username')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('name', '', array('class' => 'form-control input-sm')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('email', trans('adminlte_lang::user.email')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::email('email', '', array('class' => 'form-control input-sm')) }}
						</div>
					</div>
					<div class='form-group'>
						<label class="col-sm-2 control-label" for="inputStatus">Give Role</label>
						<div class="col-sm-10">
							@foreach ($roles as $role)
								{{ Form::checkbox('roles[]',  $role->id ) }}
								{{ Form::label($role->name, ucfirst($role->name)) }}<br>
							@endforeach
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('password', trans('adminlte_lang::user.password')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::password('password', array('class' => 'form-control input-sm')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('password_confirmation', trans('adminlte_lang::user.password_confirmation')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::password('password_confirmation', array('class' => 'form-control input-sm')) }}
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputStatus"> </label>
						<div class="col-sm-10">
							{{ Form::submit(trans('adminlte_lang::default.btn_add'), array('class' => 'btn btn-primary')) }}
						</div>
					</div>
				</div>
			</div>
			<!-- /.box -->
		</div>
	</div>
	{{ Form::close() }}
@endsection
