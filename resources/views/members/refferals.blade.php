@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::member.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::member.refferals') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::member.refferals_no') }}</th>
							<th>{{ trans('adminlte_lang::member.refferals_id') }}</th>
							<th>{{ trans('adminlte_lang::member.refferals_username') }}</th>
							<th>{{ trans('adminlte_lang::member.refferals_fullname') }}</th>
							<th>{{ trans('adminlte_lang::member.refferals_package') }}</th>
							<th>{{ trans('adminlte_lang::member.refferals_more') }}</th>
						</tr>
						<tbody>
							@foreach ($users as $key => $user)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $user->id }}</td> 
								<td>{{ $user->name }}</td> 
								<td>{{ $user->name }}</td> 
								<td></td> 
								<td>
									<a href="{{ URL::to('permissions/'.$user->id.'/edit') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_edit') }}</a>
									
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection