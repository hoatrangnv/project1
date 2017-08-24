@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title_create') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">{{ trans('adminlte_lang::permissions.header_title_create') }}</h3>
				</div>
				<div class="box-body">
					{{ Form::open(array('url' => 'permissions', 'role' => 'form')) }}
					<div class="form-group">
						{{ Form::label('name', 'Name') }}
						{{ Form::text('name', '', array('class' => 'form-control input-sm')) }}
					</div>
					@if(!$roles->isEmpty())
						<label>Assign Permission to Roles</label>
						@foreach ($roles as $role) 
							<div class="checkbox">
								<label>
									{{ Form::checkbox('roles[]',  $role->id ) }}
									{{ ucfirst($role->name) }}
								<label>
							</div>
						@endforeach
					@endif
					<br>
					{{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection