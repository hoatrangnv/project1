@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::permission.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::permission.manager') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<a href="{{ route('permissions.create') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::permission.add') }}</a>
					<div class="btn-group">
						<a href="{{ route('users.index') }}" class="btn btn-sm btn-default">{{ trans('adminlte_lang::user.header_title') }}</a>
						<a href="{{ route('roles.index') }}" class="btn btn-sm btn-default">{{ trans('adminlte_lang::role.header_title') }}</a>
					</div>
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::permission.title') }}</th>
							<th>{{ trans('adminlte_lang::permission.action') }}</th>
						</tr>
						<tbody>
							@foreach ($permissions as $permission)
							<tr>
								<td>{{ $permission->name }}</td> 
								<td>
								<a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_edit') }}</a>
								{!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $user->id] ]) !!}
								{!! Form::submit(trans('adminlte_lang::default.btn_delete'), ['class' => 'btn btn-xs btn-danger']) !!}
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
