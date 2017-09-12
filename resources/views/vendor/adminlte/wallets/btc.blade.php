@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::wallet.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::wallet.btc') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<button type="button" class="btn btn-sm btn-success" data-title="{{ trans('adminlte_lang::wallet.deposit') }}" id="btcDeposit">{{ trans('adminlte_lang::wallet.deposit') }}</button>
					<a href="{{ url('wallets/btcwithdraw') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.withdraw') }}</a>
					<a href="{{ url('wallets/btctransfer') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.buy_clp') }}</a>
				</div>
				<div class="box-body" style="padding-top:0;">
					<table class="table table-bordered table-hover table-striped dataTable">
						<tr>
							<th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
							<th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
							<th>{{ trans('adminlte_lang::wallet.wallet_type') }}</th>
							<th>{{ trans('adminlte_lang::wallet.wallet_in') }}</th>
							<th>{{ trans('adminlte_lang::wallet.wallet_out') }}</th>
							<th>{{ trans('adminlte_lang::wallet.wallet_info') }}</th>
						</tr>
						<tbody>
							@foreach ($wallets as $key => $wallet)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $wallet->created_at }}</td> 
								<td>{{ $wallet->type }}</td> 
								<td>{{ $wallet->inOut }}</td> 
								<td>{{ $wallet->inOut }}</td> 
								<td>{{ $wallet->note }}</td> 
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>
        $('#btcDeposit').on('click', function () {
            var modal = $('#modal');
            var title = $('#btcDeposit').data('title');
            modal.find('.modal-title').text(title);
            modal.find('.modal-body').val();
            modal.find('.modal-footer').hide();
            $.ajax({
                url: "{{ url('wallets/deposit') }}?action=btc",
                timeout : 15000
            }).done(function(data) {
                if (!data.err) {
                    modal.find('.modal-body').html('<input value='+data.walletAddress+'>');
                } else {
                    modal.find('.modal-body').html(data.err);
                }
            });
            modal.modal('show');
        });
	</script>

	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
@endsection