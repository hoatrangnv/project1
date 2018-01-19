@extends('adminlte::layouts.member')

@section('contentheader_title')
{{ trans('adminlte_lang::wallet.buy_package') }}
@endsection

@section('custome_css')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/icheck/skins/all.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/dataTable/media/css/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/clp.css')}}">
<style type="text/css">
	.error{
		color: #DD4B39;
	}
</style>
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
		            <a href="#" class="btn bg-olive m-b-lg" data-toggle="modal" data-target="#buy-package">Buy Package</a>
		            <div class="row">
		            	{!! Form::open(['action'=>'PackageController@buyPackage','method'=>'get']) !!}
                        <div class="col-xs-6 col-md-2 col-lg-2">
                            <div class="form-group">
                              <select class="form-control input-sm" name="type">
                                <option {{isset($_GET['type']) && $_GET['type']==''?'selected':''}} value="">Select Status</option>
                                <option {{isset($_GET['type']) && $_GET['type']==2?'selected':''}} value="2">Paid</option>
                                <option {{isset($_GET['type']) && $_GET['type']==1?'selected':''}} value="1">Not Paid</option>
                                <option {{isset($_GET['type']) && $_GET['type']==3?'selected':''}} value="3">Expired</option>
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
												<a href='#' class='btn btn-xs bg-olive pull-left'>Pay Now</a>
											@elseif($userOrder->status==2)
												<b class='text-info'>Paid</b>
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


	<script src="{{asset('plugins/dataTable/media/js/datatables.min.js')}}"></script>
    <script src="{{asset('plugins/icheck/icheck.min.js')}}"></script>
	<script type="text/javascript">
		$('.dataTables-package').DataTable({
            pageLength: 10,
            responsive: true,
            lengthChange: false,
            searching:false,
            bInfo:false,
            sort:false
        });
		var packageId = {{ Auth::user()->userData->packageId }};
        var packageIdPick = packageId;

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        })

        $('.package-wrapper').each(function(index, el) {
            $(el).hasClass('active') ? $(el) : $(el).addClass('disabled');
        });

        $('.iCheck,[name="choose-package"]+ins').click(function(event) {
        	var _packageId=packageId;
        	if(event.target.className=='iCheck-helper')
        	{
        		_packageId=$(this).parent().children('input[type="radio"]').val();
        		packageIdPick=_packageId;
        	}
        	if(event.target.className=='m-l-xxs' || event.target.className=="iCheck hover")
        	{
        		_packageId=$(this).children().find('input[type="radio"]').val();
        		packageIdPick=_packageId;
        	}
        	if (parseInt(_packageId)>0)
        	{
        		if (parseInt(_packageId) < parseInt(packageId))
        		{
        			swal("Whoops","You can not downgrade package.","error");
        		}
        		if (_packageId == packageId) {
        			swal("Whoops","You purchased this package.","error");
        		}
        	}

        	$('#packageId').val(_packageId);
        	packageIdPick=_packageId;

            $('.package-wrapper').each(function(index, el) {
                $(el).hasClass('active') ? ($(el).removeClass('active'), $(el).addClass('disabled')) : $(el);
            });
            $(this).closest('.package-wrapper').removeClass('disabled');
            $(this).closest('.package-wrapper').addClass('active');



        });



        $('#btn_submit_clp, #btn_submit_btc').click(function(){
        	$('#package_term_error').text('');
        	var walletId=$(this).attr('data-wid');
        	if (parseInt(packageIdPick)>0)
        	{
        		if (parseInt(packageIdPick) < parseInt(packageId))
        		{
        			swal("Whoops","You can not downgrade package.","error");
        		}
        		else if (packageIdPick == packageId) {
        			swal("Whoops","You purchased this package.","error");
        		}
        		else 
        		{
        			$('#walletId').val(walletId);
        			if($('#termsPackage').is(':checked'))
        			{
        				$('#buy-package').modal('hide');
        				swal({
                          title: "Are you sure?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-info",
                          confirmButtonText: "Yes, buy it!",
                          closeOnConfirm: false
                        },function(){
                          $('#fBuy').submit();
                        });
        			}
        			else
        			{
        				$('#package_term_error').text('Please checked term!');
        				return false;
        			}
        		}
        	}

        });


	</script>

@stop