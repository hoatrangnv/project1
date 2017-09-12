@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::mybonus.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::mybonus.faststart') }}
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
							<th>{{ trans('adminlte_lang::mybonus.no') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.date_time') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.generation') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.partner') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.amount') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.reinvest') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.transfer_withdraw') }}</th>
						</tr>
						<tbody>
							@foreach ($fastStarts as $key => $fastStart)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $fastStart->created_at }}</td>
								<td>{{ $fastStart->generation }}</td>
								<td>{{ $fastStart->users->name }}</td>
								<td>{{ $fastStart->amount }}</td>
								<td>{{ round($fastStart->amount*40/100) }}</td>
								<td>{{ round($fastStart->amount*60/100) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection