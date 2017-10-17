@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::mybonus.binary') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					
				</div>
				<div class="box-body table-responsive" style="padding-top:0;">
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
								<td>{{ number_format($binary->leftOpen, 2) }}</td>
								<td>{{ number_format($binary->rightOpen,2) }}</td>
								<td>{{ number_format($binary->leftNew, 2) }}</td>
								<td>{{ number_format($binary->rightNew, 2) }}</td>
								<td>{{ number_format($binary->leftOpen + $binary->leftNew, 2) }}</td>
								<td>{{ number_format($binary->rightOpen + $binary->rightNew, 2) }}</td>
								<td>{{ number_format($binary->settled, 2) }}</td>
								<td>{{ number_format($binary->bonus, 2) }}</td>
								<td>{{ $binary->bonus > 0 ? number_format(($binary->bonus*40/100), 2) : '' }}</td>
								<td>{{ $binary->bonus > 0 ? number_format(($binary->bonus*60/100), 2) : '' }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="text-center">
                    {{ $binarys->links() }}
                </div>
			</div>
		</div>
	</div>

@endsection