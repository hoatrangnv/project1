@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::mybonus.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::mybonus.binary') }}
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
							<th>{{ trans('adminlte_lang::mybonus.week') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.lopen') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.ropen') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.lnew') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.rnew') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.lover') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.rover') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.settled') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.bonus') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.reinvest') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.transfer_withdraw') }}</th>
						</tr>
						<tbody>
							@foreach ($binarys as $binary)
							<tr>
								<td>{{ date( "Y/m/d", strtotime($binary->year."W".$binary->weeked."1")) }} - {{ date( "Y/m/d", strtotime($binary->year."W".$binary->weeked."7")) }}</td>
								<td>{{ $binary->leftOpen }}</td>
								<td>{{ $binary->rightOpen }}</td>
								<td>{{ $binary->leftNew }}</td>
								<td>{{ $binary->rightNew }}</td>
								<td>{{ $binary->leftOpen + $binary->leftNew }}</td>
								<td>{{ $binary->rightOpen + $binary->rightNew }}</td>
								<td>{{ $binary->settled }}</td>
								<td>{{ $binary->bonus }}</td>
								<td>{{ $binary->bonus > 0 ? round($binary->bonus*40/100) : '' }}</td>
								<td>{{ $binary->bonus > 0 ? round($binary->bonus*60/100) : '' }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection