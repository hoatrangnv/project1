@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">{{ trans('adminlte_lang::permissions.header_title') }}</h3>
				</div>
				<div class="box-body">
					{{-- @include ('errors.list') --}}
					{{ Form::open(array('url' => 'users')) }}
					<div class="form-group">
						{{ Form::label('name', 'Name') }}
						{{ Form::text('name', '', array('class' => 'form-control input-sm')) }}
					</div>

					<div class="form-group">
						{{ Form::label('email', 'Email') }}
						{{ Form::email('email', '', array('class' => 'form-control input-sm')) }}
					</div>

					<div class='form-group'>
						@foreach ($roles as $role)
							{{ Form::checkbox('roles[]',  $role->id ) }}
							{{ Form::label($role->name, ucfirst($role->name)) }}<br>

						@endforeach
					</div>

					<div class="form-group">
						{{ Form::label('password', 'Password') }}<br>
						{{ Form::password('password', array('class' => 'form-control input-sm')) }}

					</div>

					<div class="form-group">
						{{ Form::label('password', 'Confirm Password') }}<br>
						{{ Form::password('password_confirmation', array('class' => 'form-control input-sm')) }}

					</div>

					{{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

					{{ Form::close() }}
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection
