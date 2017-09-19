@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::wallet.clp') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{ url('wallets/buysellclp') }}" class="btn btn-sm btn-success">{{ trans('adminlte_lang::wallet.sell_clp') }}</a>
					<a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#buy-package" >Buy package</a>
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
								<td>
									@if($wallet->inOut=='in')
										<span class="glyphicon glyphicon-log-in text-primary"></span>
									@endif
								</td>
								<td>
									@if($wallet->inOut=='out')
										<span class="glyphicon glyphicon-log-out text-danger"></span>
									@endif
								</td>
								<td>{{ $wallet->note }}</td> 
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="text-center">
						{{ $wallets->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
        <div class="modal fade" id="buy-package" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Investment Package </h4>
              </div>
              <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            @if (session('flash_message'))
                                <div class="alert alert-success">
                                        {{ session('flash_message') }}
                                </div>
                            @endif
                                <div class="box">
                                    <div class="box-header">
                                        <h4>Buy investment Package</h4>
                                    </div>
                                    <div class="box-body" style="padding-top:0;">
                                        <table class="table table-bordered table-hover table-striped dataTable">
                                            <tr>
                                                <th>{{ trans('adminlte_lang::package.name') }}</th>
                                                <th>{{ trans('adminlte_lang::package.price') }}</th>
                                                <th>{{ trans('adminlte_lang::package.token') }}</th>
                                            </tr>
                                            <tbody>
                                                @foreach ($packages as $package)
                                               <tr>
                                                    <td>{{ $package->name }}</td>
                                                    <td>${{ $package->price }}</td>
                                                    <td>{{ number_format($package->price* \App\Package::Tygia) }}</td>
                                               </tr>
                                               @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-header">
                                            <h4>Choose your package</h4>
                                    </div>
                                    <div class="box-body" style="padding-top:0;">
                                        <br>
                                        {{ Form::open(array('url' => 'packages/invest')) }}
                                                <?php
                                                        Form::macro('selectPackage', function($name, $list = [], $selected = null, $options = [], $placeholder = '', $disabled = []) {
                                                                $html = '<select name="' . $name . '"';
                                                                foreach ($options as $attribute => $value) {
                                                                        $html .= ' ' . $attribute . '="' . $value . '"';
                                                                }
                                                                $html .= '>';
                                                                if($placeholder != '')
                                        $html .= '<option value="0">'.$placeholder.'</option>';
                                                                foreach ($list as $value => $text) {
                                                                        $html .= '<option value="' . $value . '"' . ($value == $selected ? ' selected="selected"' : '') ;
                                                                        if(is_array($disabled)){
                                            $html .= (in_array($value, $disabled) ? ' disabled="disabled"' : '');
                                                                        }elseif(is_integer($disabled) && $value < $disabled){
                                            $html .= ' disabled="disabled"';
                                                                        }
                                        $html .= '>' .$text . '</option>';
                                                                }
                                                                $html .= '</select>';
                                                                return $html;
                                                        });
                                                ?>
                                                <div class="form-group input-group-sm has-feedback{{ $errors->has('packageId') ? ' has-error' : '' }}">
                                                        <?php $packageId = ($user->userData ? $user->userData->packageId : null);
                                                        echo Form::selectPackage('packageId', $lstPackSelect, $packageId, ['class' => 'form-control input-sm'], 'Pick a package...', $packageId);?>
                                                        @if ($errors->has('packageId'))
                                                                <span class="help-block">
                                                                        {{ $errors->first('packageId') }}
                                                                </span>
                                                        @endif
                                                </div>
                                                <br>
                                        {{ Form::submit(trans('adminlte_lang::wallet.buy_package'), array('class' => 'btn btn-success btn-block')) }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                        </div>
                    </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
@endsection