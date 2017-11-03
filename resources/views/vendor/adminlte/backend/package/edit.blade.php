@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
@endsection
@section('contentheader_description')
	{{ trans('adminlte_lang::package.edit') }}
@endsection

@section('main-content')
	{{ Form::model($package, array('route' => array('packages.update', $package->id), 'method' => 'PUT')) }}
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						{{ Form::label('pack_id', trans('adminlte_lang::package.pack_id')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('pack_id', null, array('class' => 'form-control input-sm')) }}
							<small class="text-danger">{{ $errors->first('pack_id') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						{{ Form::label('name', trans('adminlte_lang::package.name')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('name', null, array('class' => 'form-control input-sm')) }}
							<small class="text-danger">{{ $errors->first('name') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
						{{ Form::label('price', trans('adminlte_lang::package.price')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('price', null, array('class' => 'form-control input-sm')) }}
							<small class="text-danger">{{ $errors->first('price') }}</small>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('bonus', trans('adminlte_lang::package.bonus')+':',  array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('bonus', null, array('class' => 'form-control input-sm')) }}
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