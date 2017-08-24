@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permissions.header_title') }}
@endsection

@section('main-content')
	<a href="{{ URL::to('permissions/create') }}" class="btn btn-success">Add Permission</a>
	<a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
    <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
    <br>
    <br>
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">{{ trans('adminlte_lang::permissions.header_title') }}</h3>
				</div>
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>{{ trans('adminlte_lang::permissions.title') }}</th>
							<th>{{ trans('adminlte_lang::permissions.action') }}</th>
						</tr>
						<tbody>
							@foreach ($permissions as $permission)
							<tr>
								<td>{{ $permission->name }}</td> 
								<td>
								<a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;">Edit</a>
								{!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id] ]) !!}
								{!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger']) !!}
								{!! Form::close() !!}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
@endsection
