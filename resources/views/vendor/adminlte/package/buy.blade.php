@extends('adminlte::layouts.member')

@section('contentheader_title')
{{ trans('adminlte_lang::wallet.buy_package') }}
@endsection

@section('custome_css')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/dataTable/media/css/datatables.min.css')}}">

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
		    <!-- Your Page Content Here -->
		    <div class="row">
		      <div class="col-xs-12">
		        <div class="box">
		          <div class="box-header">
		            <h3 class="box-title">Buy Package</h3>
		          </div>
		          <div class="box-body">
		            <a href="javascript:;" class="btn bg-olive m-b-lg btn-buyPack">Buy Package</a>
		            <div class="row">
		            	{!! Form::open(['action'=>'PackageController@buyPackage','method'=>'get']) !!}
                        <div class="col-xs-6 col-md-2 col-lg-2">
                            <div class="form-group">
                              <select class="form-control input-sm" name="type">
                              	@if(count($filters)>0)
                              		@foreach($filters as $fKey=>$fVal)
                              			<option {{isset($_GET['type']) && $_GET['type']==$fKey?'selected':''}}  value="{{$fKey}}">{{$fVal}}</option>
                              		@endforeach
                              	@endif
                              </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-2 col-lg-2 ">
                            <button class="btn btn-sm btn-primary" id="btn_filter" type="submit">Filter</button>
                            <button class="btn btn-sm bg-olive" onclick="window.location.href='{{URL::to('packages/buy')}}'" id="btn_filter_clear" type="button">Clear</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
		            <div class="table-responsive">
		              <table class="table table-striped table-hover dataTables-package" cellspacing="0" width="100%" style="width:100%">
		                <thead>
		                  	<tr>
	                            <th>Date/Time</th>
	                            <th>Package</th>
	                            <th>Purchased By</th>
	                            <th>CLP Amount</th>
	                            <th>BTC Amount</th>
	                            <th>Action</th>
                          	</tr>
		                </thead>
		                <tbody>
		                	@if(count($userOrders)>0)
		                		@foreach($userOrders as $userOrder)
									<tr>
										<td>{{$userOrder->buy_date}}</td>
										<td>{{$userOrder->package->name}}</td>
										<td>{{$userOrder->walletType==2?'BTC':'CLP'}}</td>
										<td>{{$userOrder->amountCLP}}</td>
										<td>{{$userOrder->amountBTC}}</td>
										<td>
											@if($userOrder->status==1)
												<b class="text-warning small pull-left"><?=floor($userOrder->timeLeft).' min(s) left';
													?></b>
												<div class="pull-right">
													<a href='javascript:;' class='btn btn-xs bg-olive btn-pay' data-packname="{{$userOrder->package->name}}" data-walletType="{{$userOrder->walletType}}" data-amountclp="{{$userOrder->amountCLP}}" data-amountbtc="{{$userOrder->amountBTC}}" data-id="{{$userOrder->id}}" data-time="{{floor($userOrder->timeLeft)}}" data-package-id="{{$userOrder->packageId}}">Pay Now</a>
													<a href="javascript:;" data-name="{{$userOrder->package->name}}" class="btn btn-danger btn-xs btn-cancel" data-id="{{$userOrder->id}}">Cancel</a>
													
												</div>
												
												
											@elseif($userOrder->status==2)
												<b class='text-info'>Paid</b>
											@elseif($userOrder->status==4)
												<b class="text-warning">Canceled</b>
											@else
												<b class='text-danger'>Expired</b>
											@endif
										</td>
									</tr>
		                		@endforeach
		                	@endif
		                </tbody>
		              </table>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
		</section>
	</div>
	{!! Form::open(['action'=>'UserOrderController@payOrder','method'=>'post','style'=>'display:none','id'=>'fPay']) !!}
		<input type="hidden" name="orderId" id="orderId" />
	{!! Form::close() !!}
	
	{!! Form::open(['action'=>'UserOrderController@cancelOrder','method'=>'post','style'=>'display:none','id'=>'fCancel']) !!}
		<input type="hidden" name="orderId" id="oId" />
	{!! Form::close() !!}

	<script src="{{asset('plugins/dataTable/media/js/datatables.min.js')}}"></script>
    
	<script type="text/javascript">
	
		$('.dataTables-package').DataTable({
            pageLength: 10,
            responsive: true,
            lengthChange: false,
            searching:false,
            bInfo:false,
            sort:false
        });

		$(document).on('click','.btn-cancel',function(){
			var id=$(this).attr('data-id');
			var name=$(this).attr('data-name');
			var currPack={{Auth::user()->userData->packageId}};
			var action='Buy';
			if(currPack>0)
				action='Upgrade to';
			var title='Are you going to cancel the '+action+' '+name+' package Order?';
			swal({
              title: title,
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-info",
              confirmButtonText: "Yes",
              closeOnConfirm: false
            },function(){
              $('#oId').val(id);
              $('#fCancel').submit();
            });

		});

		$(document).on('click','.btn-pay',function(){
			var currPack={{Auth::user()->userData->packageId}};
			var currPackName="{{isset(Auth::user()->userData->package->name)?Auth::user()->userData->package->name:''}}";
			var pid=$(this).attr('data-package-id');
			var oid=$(this).attr('data-id');
			var packName=$(this).attr('data-packname');
			var walletType=$(this).attr('data-walletType');
			var amountCLP=$(this).attr('data-amountclp');
			var amountBTC=$(this).attr('data-amountbtc');
			var time=$(this).attr('data-time');
			if(currPack > pid)
			{
				swal("Whoops","Your current package is "+currPackName+". You are unable to downgrade the package, and this order will be expired in "+time+" min(s)","error");
			}
			else if(currPack==pid){
				swal('Whoops','You have already purchased this package. This order will be expired in '+time+' min(s)','error');
			}
			else
			{
				$('#orderId').val(oid);

				var amount=amountBTC!=0?amountBTC:amountCLP;
				var wallet='CLP';
					if(walletType==2)
						wallet='BTC';
				var action='buy';
				if(currPack>0)
					action='upgrade to';
				var title='Are you going to '+action+' '+packName+' package. '+amount+' '+wallet+' will be deducted in your wallet.';

				swal({
	                  title: title,
	                  type: "warning",
	                  showCancelButton: true,
	                  confirmButtonClass: "btn-info",
	                  confirmButtonText: "Yes",
	                  closeOnConfirm: false
	                },function(){
	                  $('#fPay').submit();
	                });
			}
		});

	</script>

@stop