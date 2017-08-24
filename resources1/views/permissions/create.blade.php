@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title_create') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">{{ trans('adminlte_lang::permissions.header_title_create') }}</h3>
				</div>
				<div class="box-body no-padding">
					{{ Form::open(array('url' => 'permissions')) }}
					<div class="form-group">
						{{ Form::label('name', 'Name') }}
						{{ Form::text('name', '', array('class' => 'form-control')) }}
					</div>
					<br>
					@if(!$roles->isEmpty())
						<h4>Assign Permission to Roles</h4>
						@foreach ($roles as $role) 
							{{ Form::checkbox('roles[]',  $role->id ) }}
							{{ Form::label($role->name, ucfirst($role->name)) }}<br>

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