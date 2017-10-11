@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::mybonus.faststart') }}
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
							
							<th>{{ trans('adminlte_lang::mybonus.date_time') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.generation') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.partner') }}</th>
                            <th>{{ trans('adminlte_lang::mybonus.package') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.amount') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.reinvest') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.transfer_withdraw') }}</th>
						</tr>
						<tbody>
							@foreach ($fastStarts as $key => $fastStart)
								<tr>
									<td>{{ $fastStart->created_at }}</td>
									<td>{{ $fastStart->generation }}</td>
									<td>{{ $fastStart->users->name }}</td>
									<td>{{ $fastStart->package->name }}</td>
									<td>{{ number_format($fastStart->amount, 2) }}</td>
									<td>{{ number_format(($fastStart->amount*40/100), 2) }}</td>
									<td>{{ number_format(($fastStart->amount*60/100), 2) }}</td>
								</tr>							
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="text-center">
                     {{ $fastStarts->links() }}
                </div>
			</div>
		</div>
	</div>

@endsection
