@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    Package Orders
@endsection
@section('main-content')
	<link rel="stylesheet" type="text/css" href="{{asset('plugins/dataTable/media/css/datatables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('plugins/datepicker3.css')}}">
	<link rel="stylesheet" href="{{asset('css/clp.css')}}">
	<div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Package Orders</h3>
          </div>
          <div class="box-body">
            <div class="row">
            	{!! Form::open(['action'=>'Backend\UserOrderController@index','method'=>'get']) !!}
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <div class="form-group">
                    <!-- <label>Date Range</label> -->
                    <div class="input-daterange input-group" id="input-daterange">
                        <input type="text" class="input-sm form-control" id="start" name="start" value=""/>
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control"  id="end" name="end" value="" />
                    </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-2">
                    <div class="form-group">
                      <select class="form-control input-sm" id="status" name="status">
                        @if(count($status)>0)
                        	@foreach($status as $tKey=>$tVal)
                        		<option value="{{$tKey}}">{{$tVal}}</option>}
                        	@endforeach
                        @endif
                      </select>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-2">
                    <div class="form-group">
                      <select class="form-control input-sm" id="purchased" name="purchased">
                        @if(count($purchases)>0)
                        	@foreach($purchases as $pKey=>$pVal)
                        		<option value="{{$pKey}}">{{$pVal}}</option>
                        	@endforeach
                        @endif
                      </select>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-2">
                    <div class="form-group">
                      <select class="form-control input-sm" name="package" id="package">
                        <option value="">Package</option>
						@if(count($packages)>0)
							@foreach($packages as $pKey=>$pVal)
								<option value="{{$pVal->id}}">{{$pVal->name}}</option>
							@endforeach
						@endif
                      </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-6 col-md-3 col-lg-2">
                    <div class="form-group">
                      <select class="form-control input-sm" name="orderType" id="order-type">
                        @if(count($orderTypes)>0)
                            @foreach($orderTypes as $odKey=>$odType)
                                <option value="{{$odKey}}">{{$odType}}</option>
                            @endforeach
                        @endif
                      </select>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-2">
                    <div class="form-group">
                      <select class="form-control input-sm" name="originalPackage" id="original-package" disabled="">
                        <option value="">Original Package</option>
                        @if(count($packages)>0)
                            @foreach($packages as $pKey=>$pVal)
                                <option value="{{$pVal->id}}">{{$pVal->name}}</option>
                            @endforeach
                        @endif
                      </select>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-2 ">
                    <button class="btn btn-sm btn-primary" id="btn_filter" type="submit">Filter</button>
                    <button class="btn btn-sm bg-olive" onclick="window.location.href='{{route('backend.package_order')}}'" id="btn_filter_clear" type="button">Clear</button>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-hover dataTables-orders" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>Date/Time</th>
                    <th>Package</th>
                    <th>Purchased By</th>
                    <th>CLP Amount</th>
                    <th>BTC Amount</th>
                    <th>Order Type</th>
                    <th>Original Package</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                	@if(count($orders)>0)
                		@foreach($orders as $oKey=>$oVal)
                			<tr>
                				<td><i class='fa fa-user'></i>&nbsp;{{$oVal->user->name}}</td>
                				<td>{{$oVal->buy_date}}</td>
                				<td>{{$oVal->package->name}}</td>
                				<td>{{$oVal->walletType==2?'BTC':'CLP'}}</td>
                				<td>{{$oVal->amountCLP}}</td>
                				<td>{{$oVal->amountBTC}}</td>
                                <td>{{$oVal->type==1?'Buy New':'Upgrade'}}</td>
                                <td>{{$oVal->original}}</td>
                				<td>
                					@if($oVal->status==1)
                						<b class='text-success'>Pending</b>
                					@elseif($oVal->status==2)
										<b class='text-info'>Paid</b>
                                    @elseif($oVal->status==4)
                                        <b class='text-warning'>Canceled</b>
                					@else
                						<b class='text-danger'>Expired</b>
                					@endif
                				</td>
                			</tr>
                		@endforeach
                	@endif
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th>Total: </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{asset('plugins/dataTable/media/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
    	jQuery(document).ready(function(){



            //loading 

            $('#order-type').on('change',function(){
                var up=$(this).val()!=2?false:true;
                if(up)
                {
                    $('#original-package').removeAttr('disabled');
                }
                else
                {
                    $('#original-package').attr('disabled',true);
                }
            });

    		$('.dataTables-orders').DataTable({
	            searching: false,
	            // bInfo: false,
	            pageLength: 10,
	            responsive: true,
	            sort:false,
	            lengthChange: false,
	            footerCallback : function ( row, data, start, end, display ) {
	                var api = this.api(), data;
	                // Get Column Item have check
	                function getTotalInfo(col){
	                    var count = [], sumData = 0;
	                    // Get Column Data
	                    colData = api.column( col ).data();

	                    // Loop Column Data
	                    for (var i = 0; i < colData.length; i++) {
	                        colData[i]== '' ? colData[i] : count.push(colData[i])
	                    }

	                    // Sum Data
	                    for( var i = 0; i < count.length; i++ ){
	                        sumData += parseFloat( count[i] );
	                    }
                        if(!Number.isInteger(sumData))
                            sumData=sumData.toFixed(8);
	                    return sumData;
	                }

	                var col4 = getTotalInfo(4),
	                    col5 = getTotalInfo(5);
	                
	     
	                // Update footer
	                $( api.column( 4 ).footer() ).html(
	                    col4
	                );
	                $( api.column( 5 ).footer() ).html(
	                    col5
	                );
	            }
	        });
    		$('#input-daterange').datepicker({
    			format: 'yyyy-mm-dd',
	            keyboardNavigation: false,
	            forceParse: false,
	            autoclose: true
	        });


    		let url_string = window.location.href; //window.location.href
			let url = new URL(url_string);
			let start=url.searchParams.get('start');
			let end =url.searchParams.get('end');
			let status=url.searchParams.get('status');
			let purchased=url.searchParams.get('purchased');
			let package=url.searchParams.get('package');
            let orderType=url.searchParams.get('orderType');
            let originalPackage=url.searchParams.get('originalPackage');
			let today = new Date().toISOString().slice(0, 10);
			if(start!=null && start!='')
			{
				$('#start').val(start);
			}
			if(end!=null && end!='')
			{
				$('#end').val(end);
			}	

			$('#status').val(status);
			$('#purchased').val(purchased);
			$('#package').val(package);

            $('#order-type').val(orderType);
            $('#original-package').val(originalPackage);

            console.log(orderType);
            if(orderType==2)
            {
                $('#original-package').removeAttr('disabled');
            }
            else
            {
                $('#original-package').attr('disabled',true);
            }

    	});
    </script>
@stop
