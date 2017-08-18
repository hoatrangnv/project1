@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::package.add') }}
@endsection

@section('main-content')
	
	{{ Form::open(array('url' => 'packages')) }}
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						{{ Form::label('name', trans('adminlte_lang::package.name')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('name', '', array('class' => 'form-control input-sm')) }}
							<small class="text-danger">{{ $errors->first('name') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
						{{ Form::label('price', trans('adminlte_lang::package.price')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('price', '', array('class' => 'form-control input-sm')) }}
							<small class="text-danger">{{ $errors->first('price') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('token') ? ' has-error' : '' }}">
						{{ Form::label('token', trans('adminlte_lang::package.token')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('token', '', array('class' => 'form-control input-sm')) }}
							<small class="text-danger">{{ $errors->first('token') }}</small>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('replication_time', trans('adminlte_lang::package.replication')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('replication_time', '', array('class' => 'form-control input-sm')) }}
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