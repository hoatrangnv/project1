@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title_edit') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">{{ trans('adminlte_lang::permissions.header_title_edit') }}</h3>
				</div>
				<div class="box-body">
					{{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}
					<div class="form-group">
						{{ Form::label('name', 'Name') }}
						{{ Form::text('name', null, array('class' => 'form-control input-sm')) }}
					</div>
					<br>
					{{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection
