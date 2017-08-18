@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permission.header_title') }}
@endsection
@section('contentheader_description')
	{{ trans('adminlte_lang::permission.add') }}
@endsection

@section('main-content')
	{{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box box-info">
				<div class="box-body">
					{{-- @include ('errors.list') --}}
					<div class="form-group">
						{{ Form::label('name', trans('adminlte_lang::permission.title')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('name', null, array('class' => 'form-control input-sm')) }}
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