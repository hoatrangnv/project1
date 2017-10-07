@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::mybonus.loyalty') }}
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
							<th>{{ trans('adminlte_lang::mybonus.type') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.lgen1_value') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.rgen1_value') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.complete') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.bonus') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.reinvest') }}</th>
							<th>{{ trans('adminlte_lang::mybonus.transfer_withdraw') }}</th>
						</tr>
						@if($loyaltyUser)
						<tbody>
							<tr>
								<td>{{ trans('adminlte_lang::mybonus.value') }}</td>
								<td>{{ $loyaltyUser->f1Left }}</td>
								<td>{{ $loyaltyUser->f1Right }}</td>
								<td>{{ $loyaltyUser->isSilver == 1 ? trans('adminlte_lang::mybonus.silver') : '' }}</td>
								<td>{{ $loyaltyUser->isSilver == 1 ? $loyaltyBonus['silver'] : '' }}</td>
								<td>{{ $loyaltyUser->isSilver == 1 ? round($loyaltyBonus['silver']*40/100) : '' }}</td>
								<td>{{ $loyaltyUser->isSilver == 1 ? round($loyaltyBonus['silver']*60/100) : '' }}</td>
							</tr>
							<tr>
								<td>{{ trans('adminlte_lang::mybonus.silver') }}</td>
								<td>{{ $loyaltyUserData['silverLeft'] }}</td>
								<td>{{ $loyaltyUserData['silverRight'] }}</td>
								<td>{{ $loyaltyUser->isGold == 1 ? trans('adminlte_lang::mybonus.gold') : '' }}</td>
								<td>{{ $loyaltyUser->isGold == 1 ? $loyaltyBonus['gold'] : '' }}</td>
								<td>{{ $loyaltyUser->isGold == 1 ? round($loyaltyBonus['gold']*40/100) : '' }}</td>
								<td>{{ $loyaltyUser->isGold == 1 ? round($loyaltyBonus['gold']*60/100) : '' }}</td>
							</tr>
							<tr>
								<td>{{ trans('adminlte_lang::mybonus.gold') }}</td>
								<td>{{ $loyaltyUserData['goldLeft'] }}</td>
								<td>{{ $loyaltyUserData['goldRight'] }}</td>
								<td>{{ $loyaltyUser->isPear == 1 ? trans('adminlte_lang::mybonus.pear') : '' }}</td>
								<td>{{ $loyaltyUser->isPear == 1 ? $loyaltyBonus['pear'] : '' }}</td>
								<td>{{ $loyaltyUser->isPear == 1 ? round($loyaltyBonus['pear']*40/100) : '' }}</td>
								<td>{{ $loyaltyUser->isPear == 1 ? round($loyaltyBonus['pear']*60/100) : '' }}</td>
							</tr>
							<tr>
								<td>{{ trans('adminlte_lang::mybonus.pear') }}</td>
								<td>{{ $loyaltyUserData['pearLeft'] }}</td>
								<td>{{ $loyaltyUserData['pearRight'] }}</td>
								<td>{{ $loyaltyUser->isEmerald == 1 ? trans('adminlte_lang::mybonus.emerald') : '' }}</td>
								<td>{{ $loyaltyUser->isEmerald == 1 ? $loyaltyBonus['emerald'] : '' }}</td>
								<td>{{ $loyaltyUser->isEmerald == 1 ? round($loyaltyBonus['emerald']*40/100) : '' }}</td>
								<td>{{ $loyaltyUser->isEmerald == 1 ? round($loyaltyBonus['emerald']*60/100) : '' }}</td>
							</tr>
							<tr>
								<td>{{ trans('adminlte_lang::mybonus.emerald') }}</td>
								<td>{{ $loyaltyUserData['emeraldLeft'] }}</td>
								<td>{{ $loyaltyUserData['emeraldRight'] }}</td>
								<td>{{ $loyaltyUser->isDiamond == 1 ? trans('adminlte_lang::mybonus.diamond') : '' }}</td>
								<td>{{ $loyaltyUser->isDiamond == 1 ? $loyaltyBonus['diamond'] : '' }}</td>
								<td>{{ $loyaltyUser->isDiamond == 1 ? round($loyaltyBonus['diamond']*40/100) : '' }}</td>
								<td>{{ $loyaltyUser->isDiamond == 1 ? round($loyaltyBonus['diamond']*60/100) : '' }}</td>
							</tr>
							<tr>
								<td>{{ trans('adminlte_lang::mybonus.diamond') }}</td>
								<td>{{ $loyaltyUserData['diamondLeft'] }}</td>
								<td>{{ $loyaltyUserData['diamondRight'] }}</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection