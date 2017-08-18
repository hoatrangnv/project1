@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permission.header_title') }}
@endsection
@section('contentheader_description')
	{{ trans('adminlte_lang::permission.add') }}
@endsection

@section('main-content')
	{{ Form::open(array('url' => 'permissions')) }}
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box box-info">
				<div class="box-body">
					{{-- @include ('errors.list') --}}
					<div class="form-group">
						{{ Form::label('name', trans('adminlte_lang::permission.title')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('name', '', array('class' => 'form-control input-sm')) }}
						</div>
					</div>
					<div class='form-group'>
						<label class="col-sm-2 control-label" for="inputStatus">Assign Permission to Roles</label>
						<div class="col-sm-10">
							@if(!$roles->isEmpty())
								@foreach ($roles as $role) 
									{{ Form::checkbox('roles[]',  $role->id ) }}
									{{ Form::label($role->name, ucfirst($role->name)) }}<br>

								@endforeach
							@endif
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
@endsection