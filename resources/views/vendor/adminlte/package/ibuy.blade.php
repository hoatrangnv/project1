@extends('adminlte::layouts.member')

@section('contentheader_title')
{{ trans('adminlte_lang::wallet.buy_package') }}
@endsection

@section('main-content')
	@if ( session()->has("errorMessage") )
        <div class="callout callout-danger">
            <h4>Warning!</h4>
            <p>{!! session("errorMessage") !!}</p>
        </div>
        {{ session()->forget('errorMessage') }}
    @elseif ( session()->has("successMessage") )
        <div class="callout callout-success">
            <h4>Success</h4>
            <p>{!! session("successMessage") !!}</p>
        </div>
        {{ session()->forget('successMessage') }}
    @else
        <div></div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
    	<section class="content">
    		<div class="row">
                <div class="col-xs-12">
                    <div class="box">
                    	<div class="box-body">
                    		@if(count($packages)>0)
		                        @foreach($packages as $pKey=>$pVal)
		                            <div class="col-md-4 m-b-lg">
		                                  <div class="package-wrapper {{floatval($pKey+1)==Auth::user()->userData->packageId?'active':''}} {{strtolower($pVal->name)=='small'?'Small':strtolower($pVal->name)}}">
		                                    <div class="package-title">
		                                      <div class="package-logo">
		                                        <img src="{{asset('img/p-'.strtolower($pVal->name).'.png')}}"/>
		                                        {{$pVal->name}}
		                                      </div>
		                                    </div>
		                                    <div class="package-content">
		                                      <div class="item">
		                                        <div class="h1 no-m">${{number_format($pVal->price,0)}}</div>
		                                      </div>
		                                      <div class="item display-flex justify-content-center">
		                                        <span class="m-r-lg">Equivalent CLP<div class="h4 no-m"><b><span class="icon-clp-icon"></span><clp-1>{{number_format($pVal->price/$ExchangeRate['CLP_USD'],2)}}</clp-1></b></div></span>
		                                        <span class="m-l-lg">Equivalent BTC<div class="h4 no-m"><b><span class="fa fa-btc"></span><btc-1>{{number_format($pVal->price/$ExchangeRate['BTC_USD'],5)}}</btc-1></b></div></span>
		                                      </div>
		                                      <div class="item">
		                                        Reward<div class="h4 no-m"><b>{{$pVal->bonus*100}}% / Day</b></div>
		                                      </div>
		                                      <div class="item">
		                                        <label class="iCheck">
		                                          <input type="radio" value="{{$pVal->id}}" name="choose-package" {{floatval($pKey+1)==Auth::user()->userData->packageId?'checked':''}} class="flat-red">
		                                          <span class="m-l-xxs">Choose</span>
		                                        </label>
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div>
		                        @endforeach
		                    @else
		                        <h1 class="text-center">There are no packages to buy</h1>
		                    @endif
		                    
		                    
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
			                      <label class="iCheck">
			                        <input type="checkbox" name="terms" id="termsPackage" class="flat-red">
			                        <a class="m-l-xxs" href="/package-term-condition.html" target="_blank">Term and condition</a>
			                      </label>
			                      <span class="help-block error" id="package_term_error"></span>
			                    </div>

			                  <p>Buy Package by</p>
			                    <button class="btn btn-success btn_submit_clp" data-wid="3" type="button">CLP Wallet</button>
			                    <button class="btn btn-success btn_submit_btc" data-wid="2" type="button">BTC Wallet</button>
								<button class="btn btn-danger pull-right" onclick="window.history.back()" type="button" data-dismiss="modal">Back</button>
							</div>
                    	</div>
                    </div>
					
                </div>
	


              </div>
    	</section>
    </div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$('#buy-package').remove();
		});
	</script>
@stop
